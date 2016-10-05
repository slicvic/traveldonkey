<?php
namespace App\Services\Expedia\Api\Response;

use App\Contracts\SuggestionServiceResponseInterface;

class ExpediaSuggestionApiResponse extends ExpediaApiAbstractResponse implements SuggestionServiceResponseInterface
{
    /**
     * @var array
     */
    private $results;

    /**
     * @inheritdoc
     */
    public function __construct(int $status, string $body)
    {
        parent::__construct($status, $body);

        $this->prepareResults();
    }

    /**
     * Get results.
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Extract results from raw response and prepare it for client.
     */
    private function prepareResults()
    {
        $this->results = [];

        if ($this->status != 200 || !$this->rawResponseObject) {
            return;
        }

        if ($this->rawResponseObject->rc != 'OK' || empty($this->rawResponseObject->sr)) {
            return;
        }

        $this->results = $this->rawResponseObject->sr;

        foreach ($this->results as $data) {
            $data->d = str_replace(['<B>', '</B>'], ['', ''], $data->d);
        }
    }
}
