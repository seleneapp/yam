<?php

/**
 * This File is part of the Yam\Controllers package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\Controllers;

use \Yam\Entities\Exception\EntityCreateException;
use \Yam\Validators\Exception\ValidationException;
use \Yam\Entities\Exception\EntityNotFoundExcepion;
use \Illuminate\Routing\Controller as BaseController;
use \Illuminate\Support\Contracts\ArrayableInterface;

/**
 * @abstract class AbstractResourceController extends Illumimate\Routing\Controller
 * @see Illumimate\Routing\Controller
 * @abstract
 *
 * @package Yam\Controllers
 * @version $Id$
 * @author Thomas Appel <mail@thomas-appel.com>
 * @license MIT
 */
abstract class AbstractResourceController extends BaseController
{
    /**
     * getResourceIndex
     *
     * @param mixed $options
     *
     * @access public
     * @abstract
     * @return mixed
     */
    abstract public function getResourceIndex($options = null);

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
    abstract public function getResource($id, $options = null);

    /**
     * createResource
     *
     *
     * @access public
     * @abstract
     * @return mixed
     */
    abstract public function createResource();

    /**
     * updateResource
     *
     * @param mixed $id
     *
     * @access public
     * @abstract
     * @return mixed
     */
    abstract public function updateResource($id);

    /**
     * deleteResource
     *
     * @param mixed $id
     *
     * @access public
     * @abstract
     * @return mixed
     */
    abstract public function deleteResource($id);

    /**
     * {@inheritdoc}
     */
	public function callAction($method, $parameters)
	{
        try {
            $response = parent::callAction($method, $parameters);
        } catch (ValidationException $e) {
            $response = $this->createValidationErrorResponse($e);
        } catch (EntityCreateException $e) {
            $response = $this->createResourceErrorResponse($e);
        } catch (EntityNotFoundResponse $e) {
            $response = $this->createResourceNotFoundResponse($e);
        } catch (\Exception $e) {
            $response = $this->createExceptionResponse($e);
        }

        return $response;
    }

    /**
     * createExceptionResponse
     *
     * @param ValidationException $exception
     *
     * @access protected
     * @return mixed
     */
    protected function createExceptionResponse(\Exception $exception)
    {
        throw $exception;
        $message = $exception->getMessage();
        $file    = $exception->getFile();
        $line    = $exception->getLine();

        return \Response::json(compact('message', 'file', 'line'), 500);
    }

    /**
     * createValidationErrorResponse
     *
     * @param ValidationException $exception
     *
     * @access protected
     * @return array
     */
    protected function createValidationErrorResponse(ValidationException $exception)
    {
        $message = $exception->getMessage();
        $errors  = $exception->getErrors();

        return compact('message', 'errors');
    }

    /**
     * createResourceErrorResponse
     *
     * @param EntityCreateException $exception
     *
     * @access protected
     * @return array
     */
    protected function createResourceErrorResponse(EntityCreateException $exception)
    {
        $message = $exception->getMessage();
        return new \JsonResonse(compact('message'), 500);
    }

    /**
     * createResourceErrorResponse
     *
     * @param EntityCreateException $exception
     *
     * @access protected
     * @return array
     */
    protected function createResourceNotFoundResponse(EntityCreateException $exception)
    {
        $message = $exception->getMessage();
        return \Response::json(compact('message'), 404);
    }

    /**
     * createResourceCreateResponse
     *
     * @param Entity $entity
     *
     * @access protected
     * @return mixed
     */
    protected function createResourceCreateResponse(ArrayableInterface $data)
    {
        return \Response::json($data, 201);
    }

    /**
     * createResourceUpdateResponse
     *
     * @param Entity $entity
     *
     * @access protected
     * @return mixed
     */
    protected function createResourceUpdateResponse(ArrayableInterface $data)
    {
        return \Response::json($data, 200);
    }

    /**
     * createResourceDeleteResponse
     *
     *
     * @access protected
     * @return mixed
     */
    protected function createResourceDeleteResponse()
    {
        return \Response::json([], 204);
    }
}
