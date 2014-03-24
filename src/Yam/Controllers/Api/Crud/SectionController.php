<?php

/**
 * This File is part of the Yam\Controllers\Api\Crud package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\Controllers\Api\Crud;

use \Input;
use \Yam\Entities\Repositories\SectionRepository;
use \Yam\Controllers\Api\AbstractResourceController;

/**
 * @class SectionController extends AbstractResourceController
 * @see AbstractResourceController
 *
 * @package Yam\Controllers\Api\Crud
 * @version $Id$
 * @author Thomas Appel <mail@thomas-appel.com>
 * @license MIT
 */
class SectionController extends AbstractResourceController
{
    public function __construct(SectionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * getResourceIndex
     *
     * @param mixed $options
     *
     * @access public
     * @abstract
     * @return mixed
     */
    public function getResourceIndex($options = null)
    {
        return $this->repository->findAll();
    }

    /**
     * getResource
     *
     * @param mixed $id
     * @param mixed $options
     *
     * @access public
     * @abstract
     * @return mixed
     */
    public function getResource($id, $options = null)
    {
        return $this->repository->find($id);
    }

    /**
     * createResource
     *
     *
     * @access public
     * @abstract
     * @return mixed
     */
    public function createResource()
    {
        $data = Input::all();
        return $this->createResourceCreateResponse($this->repository->create($data));
    }

    /**
     * updateResource
     *
     * @param mixed $id
     *
     * @access public
     * @abstract
     * @return mixed
     */
    public function updateResource($id)
    {
        $data = Input::all();
        return $this->createResourceUpdateResponse($this->repository->update($id, $data));
    }

    /**
     * deleteResource
     *
     * @param mixed $id
     *
     * @access public
     * @abstract
     * @return mixed
     */
    public function deleteResource($id)
    {
        return $this->createResourceDeleteResponse($this->repository->delete($id));
    }
}
