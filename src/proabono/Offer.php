<?php


/**
 * Class Offer
 */


class Offer {


    // integer / Id of the Offer Object
    public $id;
    // string / Name of the Offer
    public $name;
    // string / Identifier used within your own application for this offer
    // Unique for a given segment, meaning you can decline the same offer in multiple segments
    public $refOffer;
    // boolean / Visibility of the offer in the hosted pages
    public $is_visible;
    // integer / Amount of the Upfront fee, Setup fee or Initial fee of your offer in cents
    public $amountUpFront;
    // integer / Amount of the Trial period in cents
    public $amountTrial;
    // number / Number of Trial Time Unit
    public $durationTrial;
    // string / Time Unit of Trial
    public $unitTrial;
    // integer / Amount of each recurrence in cents
    public $amountRecurrence;
    // integer / Number of Recurrence
    public $durationRecurrence;
    // string / Time Unit of Recurrence
    public $unitRecurrence;
    // integer / Number of Recurrences
    public $countRecurrence;
    // integer / Minimum recurrences the offer will be committed to pay
    public $countMinRecurrences;
    // integer / Amount of the Termination Fee in cents
    public $amountTermination;
    // string / State of the Offer
    public $stateLife;
    // string / Collection of Features with Quantities and Properties
    public $features;
    // string / Useful links concerning the Offer
    public $links;


    /**
     * Retrieve an offer from the api,
     * by the reference offer.
     *
     * @param string $refOffer
     * @return Response
     * @throws Exception
     */
    public function fetch($refOffer) {

        $url = PATH_OFFER;

        $url = Utils::urlParam($url, 'ReferenceOffer', $refOffer);

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
        $this->name = isset($data->Name) ? $data->Name : null;
        $this->refOffer = isset($data->ReferenceOffer) ? $data->ReferenceOffer : null;
        $this->is_visible = isset($data->IsVisible) ? $data->IsVisible : null;
        $this->amountUpFront = isset($data->AmountUpFront) ? $data->AmountUpFront : null;
        $this->amountTrial = isset($data->AmountTrial) ? $data->AmountTrial : null;
        $this->durationTrial = isset($data->DurationTrial) ? $data->DurationTrial : null;
        $this->unitTrial = isset($data->UnitTrial) ? $data->UnitTrial : null;
        $this->amountRecurrence = isset($data->AmountRecurrence) ? $data->AmountRecurrence : null;
        $this->durationRecurrence = isset($data->DurationRecurrence) ? $data->DurationRecurrence : null;
        $this->unitRecurrence = isset($data->UnitRecurrence) ? $data->UnitRecurrence : null;
        $this->countRecurrence = isset($data->CountRecurrences) ? $data->CountRecurrences : null;
        $this->countMinRecurrences = isset($data->CountMinRecurrences) ? $data->CountMinRecurrences : null;
        $this->amountTermination = isset($data->AmountTermination) ? $data->AmountTermination : null;
        $this->stateLife = isset($data->StateLife) ? $data->StateLife : null;
        $this->features = isset($data->Features) ? $data->Features : null;
        $this->links = isset($data->Links) ? $data->Links : null;
    }


}