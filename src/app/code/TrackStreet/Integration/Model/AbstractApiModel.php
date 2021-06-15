<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Model;

use TrackStreet\Integration\Api\ApiModelInterface;
use TrackStreet\Integration\Api\ReverbServiceInterface;

/**
 * Class AbstractApiModel
 * @package TrackStreet\Integration\Model
 */
class AbstractApiModel extends \Magento\Framework\DataObject implements ApiModelInterface
{

    /**
     * @var ReverbServiceInterface
     */
    protected $reverbService;

    /**
     * @var array
     */
    protected $_errors = [];

    /**
     * @var array
     */
    protected $actions = [];

    /**
     * @var string|null
     */
    protected $actionEntity;


    /**
     * @var string|null
     */
    protected $idField;

    /**
     * Customer constructor.
     * @param ReverbServiceInterface $reverbService
     * @param array $data
     */
    public function __construct(
        ReverbServiceInterface $reverbService,
        string $idField,
        array $actions,
        string $actionEntity,
        array $data = []
    )
    {
        parent::__construct($data);
        $this->reverbService = $reverbService;
        $this->actions = $actions;
        $this->actionEntity = $actionEntity;
        $this->idField = $idField;
    }

    /**
     * @return string|null
     */
    public function getIdField()
    {
        return $this->idField;
    }

    /**
     * @param $name
     * @return $this|mixed
     */
    public function setIdField($name)
    {
        return $this->idField = $name;
        return $this;
    }

    /**
     * @param $key
     * @return mixed|string
     */
    public function getAction($key)
    {
        $actions = $this->getActions();
        if (isset($actions[$key])) {
            return $actions[$key];
        }
        if (isset($actions['default'])) {
            return $actions['default'];
        }
        return '';
    }

    /**
     * @return string|null
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @return string|null
     */
    public function getActionEntity()
    {
        return $this->actionEntity;
    }

    /**
     * @param $action
     * @return $this|mixed
     */
    public function setActions($actions)
    {
        $this->actions = $actions;
        return $this;
    }

    /**
     * @param $actionEntity
     * @return $this|mixed
     */
    public function setActionEntity($actionEntity)
    {
        $this->actionEntity = $actionEntity;
        return $this;
    }

    /**
     * @return $this
     */
    public function save()
    {
        $this->resetErrors();
        $uuid = ($this->getData('uuid')) ? $this->getData('uuid') : $this->getData($this->getIdField());
        if ($this->getUuid()) {
            $this->reverbService->put($this->getAction('save') . "/" . $uuid, $this->getData());
        } else {
            $data = $this->reverbService->post($this->getAction('save'), $this->getData());
            $this->parseResult($data);
        }

        return $this;
    }

    /**
     * @param string $id
     * @return $this|mixed
     */
    public function load($id)
    {

        $this->resetErrors();
        $this->unsetData();
        $data = $this->reverbService->get($this->getAction('load') . "/" . $id);
        $this->parseResult($data);

        return $this;
    }

    /**
     * @return $this
     */
    public function delete()
    {
        $uuid = ($this->getData('uuid')) ? $this->getData('uuid') : $this->getData($this->getIdField());
        if ($uuid) {
            $data = $this->reverbService->delete($this->getAction('delete'). "/" .$uuid);
            $this->parseResult($data);
        }
        return $this;
    }

    /**
     * @return int|void
     */
    public function hasErrors()
    {
        return count($this->_errors);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * @return $this
     */
    public function resetErrors()
    {
        $this->_errors = [];
        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    protected function parseResult($data)
    {
        if (isset($data['response']) && $data['response']['code'] == 200) {
            if (isset($data['response']['data']) && isset($data['response']['data'][$this->getActionEntity()])) {
                if(isset($data['response']['data'][$this->getActionEntity()][0]))
                    $this->addData(current($data['response']['data'][$this->getActionEntity()]));
                else
                    $this->addData($data['response']['data'][$this->getActionEntity()]);
            }
        } else {
            $this->_errors[] = $data['response'];
        }
        return $this;
    }

}
