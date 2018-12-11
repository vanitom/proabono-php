<?php


/**
 * Class Usage
 */


class Usage {


    // integer / Id of the Segment in which the Customer has been created
    public $idSegment;
    // integer / Id of the Feature related to this Usage
    public $idFeature;
    // integer / Id of the Customer related to this Usage
    public $idCustomer;
    // integer / Id of the Subscription related to this Usage. If not returned, it means multiple subscriptions matches that usage
    public $idSubscription;
    // string / Reference of the segment in which the offer has been created
    public $refSegment;
    // string / Reference of the Feature shared with your site/service and ProAbono
    public $refFeature;
    // string / The unique identifier used within your own application for this offer
    public $refCustomer;
    // string / Type of the Feature (OnOff, Limitation, Consumption)
    public $typeFeature;
    // boolean / (Only for OnOff offer) It indicates if the offer is included in the subscription of the offer
    // False indicates that the offer can be enabled
    public $is_included;
    // boolean / (Only for OnOff offer) It indicates if the offer is enabled in the subscription of the offer
    public $is_enabled;
    // integer / (Only for Limitation or Consumption offer) Limitation, quota or volume of the Feature available in the Subscription of the Customer.
    // If not provided it means ‘unlimited’
    public $quantityIncluded;
    // integer / (Only for Limitation or Consumption offer) Limitation, quota or volume of the Feature currently used in the Subscription of the Customer.
    // If not provided it means ‘unlimited’
    public $quantityCurrent;
    // string / This is the start of the considered billing period. Used to enforce quota (like 10 emails per months)
    public $datePeriodStart;
    // string / This is the end of the considered billing period. Used to enforce quota
    public $datePeriodEnd;

    public $dateStamp;

    public $increment;


    /**
     * Retrieve a single usage,
     * by a reference feature and a reference subscription.
     *
     * @param $refFeature
     * @param $refCustomer
     * @return Response
     * @throws Exception
     */
    public function fetch($refFeature, $refCustomer) {

        $url = PATH_USAGE;

        $url = Utils::urlParam($url, 'ReferenceFeature', $refFeature);

        $url = Utils::urlParam($url, 'ReferenceCustomer', $refCustomer);

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
        $this->idSegment = isset($data->IdSegment) ? $data->IdSegment : null;
        $this->idFeature = isset($data->IdFeature) ? $data->IdFeature : null;
        $this->idCustomer = isset($data->IdCustomer) ? $data->IdCustomer : null;
        $this->idSubscription = isset($data->IdSubscription) ? $data->IdSubscription : null;
        $this->refSegment = isset($data->ReferenceSegment) ? $data->ReferenceSegment : null;
        $this->refFeature = isset($data->ReferenceFeature) ? $data->ReferenceFeature : null;
        $this->refCustomer = isset($data->ReferenceCustomer) ? $data->ReferenceCustomer : null;
        $this->typeFeature = isset($data->TypeFeature) ? $data->TypeFeature : null;
        $this->is_included = isset($data->IsIncluded) ? $data->IsIncluded : null;
        $this->is_enabled = isset($data->IsEnabled) ? $data->IsEnabled : null;
        $this->quantityIncluded = isset($data->QuantityIncluded) ? $data->QuantityIncluded : null;
        $this->quantityCurrent = isset($data->QuantityCurrent) ? $data->QuantityCurrent : null;
        $this->datePeriodStart = isset($data->DatePeriodStart) ? $data->DatePeriodStart : null;
        $this->datePeriodEnd = isset($data->DatePeriodEnd) ? $data->DatePeriodEnd : null;
    }


    /**
     * @param $dateStamp
     * @return Response
     * @throws Exception
     */
    public function save($dateStamp) {

        // If dateStamp not exist, create a new date (ISO8601)
        if (!$dateStamp) {
            $dateStamp = date(DATE_ISO8601);
        }

        $data = array(
            'ReferenceCustomer' => $this->refCustomer,
            'ReferenceFeature' => $this->refFeature,
            'DateStamp' => $dateStamp
        );

        if ($this->increment) {
            $data['Increment'] = $this->increment;
        }
        else if ($this->quantityCurrent) {
            $data['QuantityCurrent'] = $this->quantityCurrent;
        }
        else if (isset($this->is_enabled)) {
            $data['IsEnabled'] = $this->is_enabled;
        }

        // Send url with an array.
        $response = Request::post(PATH_USAGE, $data);

        // If response is success, fill the data.
        if ($response->is_success()) {
            $this->fill($response->data);
        }
        return $response;
    }


}