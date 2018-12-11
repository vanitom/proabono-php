<?php


/**
 * Class Feature
 */


class Feature {


    // integer / Id of the Feature Object
    public $id;
    // string / The unique identifier used within your own application for this Feature
    public $refFeature;
    // string / Title of Feature
    public $titleLocalized;
    // string / Description of the Feature
    public $descriptionLocalized;
    // boolean / Visibility of the Feature in offers and hosted pages
    public $is_visible;


    /**
     * Retrieve a offer from the api,
     * by a reference feature.
     *
     * @param $refFeature
     * @return Response
     * @throws Exception
     */
    public function fetch($refFeature) {

        $url = PATH_FEATURE;

        $url = Utils::urlParam($url, 'ReferenceFeature', $refFeature);

        $response = Request::get($url);

        if ($response->is_success()) {
            $this->fill($response->data);
        }
    return $response;
    }


    /**
     * Fill our object with the raw ProAbono data.
     *
     * @param $data
     */
    public function fill($data) {
        $this->id = isset($data->Id) ? $data->Id : null;
        $this->refFeature = isset($data->ReferenceFeature) ? $data->ReferenceFeature : null;
        $this->titleLocalized = isset($data->TitleLocalized) ? $data->TitleLocalized : null;
        $this->descriptionLocalized = isset($data->DescriptionLocalized) ? $data->DescriptionLocalized : null;
        $this->is_visible = isset($data->IsVisible) ? $data->IsVisible : null;
    }


}