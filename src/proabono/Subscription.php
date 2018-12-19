<?php


/**
 * Class Subscription
 */


class Subscription {


    // integer / Id of your Subscription
    public $id;
    // integer / Id of the Segment in which your offer has been created/added
    public $idSegment;
    // integer / Id of the Offer subscribed
    public $idOffer;
    // integer / Identifier of the Customer
    public $idCustomer;
    // integer / Identifier of the Customer who buys
    public $idCustomerBuyer;
    // string / Reference of the Segment in which your offer has been created/added
    public $refSegment;
    // string / Reference of the Offer subscribed
    public $refOffer;
    // string / The unique identifier used within your own application for this offer
    public $refCustomer;
    // string / Reference of the Customer who buys (Tips: Use your own id user)
    public $refCustomerBuyer;
    // string / State of the Subscription
    public $stateSubscription;
    // string / Start Date of the Subscription
    public $dateStart;
    // string / Start Date of the billing period
    public $datePeriodStart;
    // string / End Date of the billing period
    public $datePeriodTerm;
    // string / Term Date of the Subscription
    public $dateTerm;
    // string / Estimated State of the Subscription after the current period
    public $stateSubscriptionAfterTerm;
    // boolean / Indicates if the current period is a trial period or not
    public $is_trial;
    // integer / Number of days remaining in the trial period
    public $countDaysTrial;
    // boolean / Indicates if the Customer is still in the minimum commitment period
    public $is_engaged;
    // boolean / Indicates if the Customer is currently billable
    public $is_customer_billable;
    // boolean /  Indicates if the Customer has exceeded the max duration limit of due payments
    // and/or the max limit of accumulated amount of due payments
    public $is_payment_capping_reached;
    // string / Date of the Customer Next Billing
    public $dateNextBilling;
    // string / Title of the Subscription in the language of the Customer
    public $titleLocalized;
    // integer / Amount of the Upfront fee, Setup fee or Initial fee of your offer in cents
    public $amountUpFront;
    // integer / Amount of the Trial period in cents
    public $amountTrial;
    // integer / Number of Trial Time Unit
    public $durationTrial;
    // string / Time Unit of Trial
    public $unitTrial;
    // integer / Amount of each recurrence in cents
    public $amountRecurrence;
    // integer / Number of Recurrence Time Unit
    public $durationRecurrence;
    // string / Time Unit of Recurrence
    public $unitRecurrence;
    // integer / Number of Recurrences
    public $countRecurrences;
    // integer / Minimum recurrences the offer will be committed to pay
    public $countMinRecurrences;
    // integer / Amount of the Termination Fee in cents
    public $amountTermination;
    // Collection of Features + theirs usages
    // (Can be empty if the Offer contained no offer when it was subscribed
    public $features;
    // integer / Date of the last update of the Subscription
    public $dateUpdate;
    // string / A set of key/value pairs that you can add to a subscription
    public $meta;
    // string / Collection of LinkArray. The LinkArray in the collection depends on the Subscription State
    public $links;


    /**
     * Retrieve a subscription,
     * by a reference offer.
     *
     * @param string $refCustomer
     * @return Response
     * @throws Exception
     */
    public function fetchByCustomer($refCustomer) {

        $url = PATH_SUBSCRIPTION;

        $url = Utils::urlParam($url, 'ReferenceCustomer', $refCustomer);

        $response = Request::get($url);

        if ($response->is_success()) {
            $this->fill($response->data);
        }
        return $response;
    }


    /**
     * Retrieve a subscription,
     * by an id.
     *
     * @param integer $id
     * @return Response
     * @throws Exception
     */
    public function fetchById($id) {
        $url = PATH_SUBSCRIPTION . '/' . $id;

        $response = Request::get($url);

        if ($response->is_success()) {
            $this->fill($response->data);
        }
        return $response;
    }


    /**
     * Save the subscription in the api.
     *
     * @param $data
     * @return Response
     * @throws Exception
     */
    public function save($data) {

        $url = PATH_SUBSCRIPTION;

        // Send url with an array.
        $response = Request::post($url, $data);

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
        $this->idSegment = isset($data->IdSegment) ? $data->IdSegment : null;
        $this->idOffer = isset($data->IdOffer) ? $data->IdOffer : null;
        $this->idCustomer = isset($data->IdCustomer) ? $data->IdCustomer : null;
        $this->idCustomerBuyer = isset($data->IdCustomerBuyer) ? $data->IdCustomerBuyer : null;
        $this->refSegment = isset($data->ReferenceSegment) ? $data->ReferenceSegment : null;
        $this->refOffer = isset($data->ReferenceOffer) ? $data->ReferenceOffer : null;
        $this->refCustomer = isset($data->ReferenceCustomer) ? $data->ReferenceCustomer : null;
        $this->refCustomerBuyer = isset($data->ReferenceCustomerBuyer) ? $data->ReferenceCustomerBuyer : null;
        $this->stateSubscription = isset($data->StateSubscription) ? $data->StateSubscription : null;
        $this->dateStart = isset($data->DateStart) ? $data->DateStart : null;
        $this->datePeriodStart = isset($data->DatePeriodStart) ? $data->DatePeriodStart : null;
        $this->datePeriodTerm = isset($data->DatePeriodTerm) ? $data->DatePeriodTerm : null;
        $this->dateTerm = isset($data->DateTerm) ? $data->DateTerm : null;
        $this->stateSubscriptionAfterTerm = isset($data->StateSubscriptionAfterTerm) ? $data->StateSubscriptionAfterTerm : null;
        $this->is_trial = isset($data->IsTrial) ? $data->IsTrial : null;
        $this->countDaysTrial = isset($data->CountDaysTrial) ? $data->CountDaysTrial : null;
        $this->is_engaged = isset($data->IsEngaged) ? $data->IsEngaged : null;
        $this->is_customer_billable = isset($data->IsCustomerBillable) ? $data->IsCustomerBillable : null;
        $this->is_payment_capping_reached = isset($data->IsPaymentCappingReached) ? $data->IsPaymentCappingReached : null;
        $this->dateNextBilling = isset($data->DateNextBilling) ? $data->DateNextBilling : null;
        $this->titleLocalized = isset($data->TitleLocalized) ? $data->TitleLocalized : null;
        $this->amountUpFront = isset($data->AmountTrial) ? $data->AmountTrial : null;
        $this->durationTrial = isset($data->DurationTrial) ? $data->DurationTrial : null;
        $this->unitTrial = isset($data->UnitTrial) ? $data->UnitTrial : null;
        $this->amountRecurrence = isset($data->AmountRecurrence) ? $data->AmountRecurrence : null;
        $this->durationRecurrence = isset($data->DurationRecurrence) ? $data->DurationRecurrence : null;
        $this->unitRecurrence = isset($data->UnitRecurrence) ? $data->UnitRecurrence : null;
        $this->countRecurrences = isset($data->CountRecurrences) ? $data->CountRecurrences : null;
        $this->countMinRecurrences = isset($data->CountMinRecurrences) ? $data->CountMinRecurrences : null;
        $this->amountTermination = isset($data->AmountTermination) ? $data->IdSegment : null;
        $this->features = isset($data->Features) ? $data->Features : null;
        $this->dateUpdate = isset($data->DateUpdate) ? $data->DateUpdate : null;
        $this->meta = isset($data->Metadata) ? $data->Metadata : null;
        $this->links = isset($data->Links) ? $data->Links : null;
    }


}