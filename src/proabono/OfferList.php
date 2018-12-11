<?php


class OfferList extends ListBase {


    /**
     * Retrieve all offers from the api.
     *
     */
    function fetch() {

        $url = PATH_OFFERS;

        $response = Request::get($url);

        // If response success:
        if ($response->is_success()
            // and data is set:
            && (isset($response->data))) {

            foreach ($response->data->Items as $item) {

                $offer = new Offer();
                $offer->fill($item);
                $this->push($offer);

            }
        }
        return $response;
    }


}