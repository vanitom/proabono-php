<?php


/**
 * Class UsageList
 */


class UsageList extends ListBase {


    /**
     * Retrieve all usages from the api,
     * by a reference subscription and a reference feature.
     *
     * @param $page
     * @param $refCustomer
     * @param $refFeature
     * @return Response
     * @throws Exception
     */
    function fetch($page, $refCustomer, $refFeature) {

        $url = PATH_USAGES;

        $url = Utils::urlParam($url, 'Page', $page);

        $url = Utils::urlParam($url, 'ReferenceCustomer', $refCustomer);

        $url = Utils::urlParam($url, 'ReferenceFeature', $refFeature);

        $response = Request::get($url);

        // If response success:
        if ($response->is_success()
            // and data is set:
            && (isset($response->data))) {

            // Set pagination properties.
            $this->page = $response->data->Page;
            $this->sizePage = $response->data->SizePage;
            $this->count = $response->data->Count;
            $this->totalItems = $response->data->TotalItems;

            foreach ($response->data->Items as $item) {

                $usage = new Usage();
                $usage->fill($item);
                $this->push($usage);
            }
        }
        return $response;
    }


}