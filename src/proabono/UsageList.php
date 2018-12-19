<?php


/**
 * Class UsageList
 */


class UsageList extends ListBase {


    /**
     * Retrieve all usages from the api,
     * by a reference subscription and a reference feature.
     *
     * @param $refCustomer
     * @param bool $refreshCache
     * @return Response
     * @throws Exception
     */
    function fetchByCustomer($refCustomer, $refreshCache = false) {

        /////////// CACHING STRATEGY ///////////
        if (ProAbono::$useCaching) {
            // Search for that customer into the cache
            $cached = ProAbonoCache::get($refCustomer);

            // get the cached data
            $usages = UsageList::getCachedData($refCustomer, $refreshCache);
            // if we have data
            if (isset($usages)) {
                // Set pagination properties.
                $this->page = 1;
                $this->sizePage = count($usages);
                $this->count = count($usages);
                $this->totalItems = count($usages);

                foreach ($usages as $item) {

                    $converted = new Usage();
                    $converted->fill($item);
                    $this->push($converted);

                }
                // success
                return Response::success();

            }
            return Response::usageNotFound();
        }
        /////////////////////////////////

        // if we do not use the cache

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

    function fetchByFeature($refFeature, $page) {

        $url = PATH_USAGES;

        $url = Utils::urlParam($url, 'Page', $page);

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

    public static function getCachedData($refCustomer, $refreshCache) {

        // Search for that customer into the cache
        $cached = ProAbonoCache::get($refCustomer);
        // If found
        if (isset($cached)
            // If usages are cached
            && $cached->usages
            // If not too old
            && !$cached->is_expired()
            // If not refreshing
            && !$refreshCache )  {
            return $cached->usages;
        }
        /////////////////////////////////

        // if not cached OR if cache is expired

        $url = PATH_USAGES;
        $url = Utils::urlParam($url, 'ReferenceCustomer', $refCustomer);

        $response = Request::get($url);

        // If response success:
        if ($response->is_success()
            // and data is set:
            && (isset($response->data))) {
            // store into the cache
            ProAbonoCache::storeUsages($refCustomer, $response->data->Items);
            return $response->data->Items;
        }
        return null;
    }

    public static function getUsageForFeature($usages, $refFeature) {
        // if no usages, ignore
        if (!isset($usages))
            return null;

        foreach ($usages as $usage) {

            if ($usage->ReferenceFeature === $refFeature)
                return $usage;
        }
        // if not found
        return null;
    }

    public function validateSubscription($refCustomer, $idCustomer, $idSubscription) {

        $url = PATH_USAGES;

        $url = Utils::urlParam($url, 'IdCustomer', $idCustomer);

        $url = Utils::urlParam($url, 'ReferenceCustomer', $refCustomer);

        $url = Utils::urlParam($url, 'IdSubscription', $idSubscription);

        $response = Request::get($url);

        // If response success:
        if ($response->is_success()
            // and data is set:
            && (isset($response->data))) {

            return $this->fetchByCustomer($refCustomer, true);

        }
        return $response;

    }


}