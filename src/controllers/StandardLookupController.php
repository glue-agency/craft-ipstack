<?php

namespace GlueAgency\IPStack\controllers;

use craft\web\Controller;
use GlueAgency\IPStack\services\StandardLookupService;
use yii\web\Response;

class StandardLookupController extends Controller
{

    protected $allowAnonymous = true;

    /**
     * @return Response
     */
    public function actionUser(): Response
    {
        $service = new StandardLookupService();
        $data = $service->user();

        return $this->asJson($data);
    }
}
