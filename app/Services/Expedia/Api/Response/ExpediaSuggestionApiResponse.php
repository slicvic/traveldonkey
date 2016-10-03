<?php
namespace App\Services\Expedia\Api\Response;

class ExpediaSuggestionApiResponse extends ExpediaApiAbstractResponse
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

        $this->extractResults();
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
     * Extract results from body.
     */
    private function extractResults()
    {
        $this->results = [];

        if ($this->status != 200 || !$this->body) {
            return;
        }

        if ($this->body->rc != 'OK' || empty($this->body->sr)) {
            return;
        }

        $this->results = $this->body->sr;
    }
}
