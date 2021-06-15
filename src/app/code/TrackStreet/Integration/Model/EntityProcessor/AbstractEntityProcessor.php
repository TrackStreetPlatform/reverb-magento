<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Model\EntityProcessor ;
use Magento\Framework\App\ObjectManager;
use Symfony\Component\Console\Output\OutputInterface;
use TrackStreet\Integration\Api\ApiModelDataConverterInterface;
use TrackStreet\Integration\Api\EntityProcessorInterface;
use TrackStreet\Integration\Api\ApiModelInterface;
use TrackStreet\Integration\Api\UidSaverInterface;

/**
 * Class AbstractEntityProcessor
 * @package TrackStreet\Integration\Model\EntityProcessor
 */
class AbstractEntityProcessor implements EntityProcessorInterface {

    /**
     * @var object
     */
    protected $model;

    /**
     * @var ApiModelInterface
     */
    protected $apiModel;

    /**
     * @var ApiModelDataConverterInterface
     */
    protected $dataConverter;

    /**
     * @var UidSaverInterface
     */
    protected $uidSaver;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * AbstractEntityProcessor constructor.
     * @param $modelClassName
     * @param ApiModelInterface $apiModel
     * @param ApiModelDataConverterInterface $apiModelDataConverter
     * @param UidSaverInterface $uidSaver
     */
    public function __construct($modelClassName,
                                ApiModelInterface $apiModel,
                                ApiModelDataConverterInterface $apiModelDataConverter,
                                UidSaverInterface $uidSaver
    )
    {
        $this->model = ObjectManager::getInstance()->create($modelClassName['instance']);
        $this->apiModel = $apiModel;
        $this->dataConverter =  $apiModelDataConverter;
        $this->uidSaver = $uidSaver;
    }

    /**
     * @param array|string $ids
     */
    public function execute($ids = [])
    {
        if(count($ids) == 0) {
            $ids = $this->model->getCollection()->getAllIds();
        }
        foreach ($ids as $id) {
            $this->update($id);
        }
    }

    /**
     * @param $id
     */
    public function update($id){
        try {
            $this->apiModel->unsetData();
            $this->writeOutput("<info>updating entity_id: $id</info>");
            $model = $this->model->load($id);
            if($model->getReverbUuid()) {
                $this->apiModel->load($model->getReverbUuid());
            } else {
                $this->apiModel->resetErrors();
                $this->apiModel->unsetData();
            }
            $this->apiModel->addData($this->dataConverter->convert($model))->save();
            if($this->apiModel->hasErrors()) {
                foreach ($this->apiModel->getErrors() as $error) {
                    $code  = isset($error['code']) ? $error['code'] : '404';
                    $message  = isset($error['message']) ? $error['message'] : 'Syntax error';
                    $message = is_array($message) ? implode(',',$error['message']) : $message;
                    $this->writeOutput("<error>$code: $message</error>");
                }
            }
            if(!$this->apiModel->hasErrors()) {
                $this->uidSaver->save($model, $this->apiModel);
                if ($model->getReverbUuid()) {
                    $this->writeOutput("<info>entity_id:$id uuid:{$model->getReverbUuid()} has been updated</info>");
                } else {
                    $this->writeOutput("<error>entity_id:$id didn't updated</error>");
                }
            }
        } catch (\Exception $exception) {
            $this->writeOutput("<error>{$exception->getMessage()}</error>");
        }
    }

    /**
     * @param OutputInterface $output
     * @return $this|mixed
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;
        return $this;
    }

    /**
     * @return OutputInterface
     */
    public function getOutput()
    {
       return $this->output;
    }

    /**
     * @param $message
     * @return $this
     */
    public function writeOutput($message) {
        if($this->getOutput()) {
            $this->getOutput()->writeln($message);
        }
        return $this;
    }


}