<?php

declare(strict_types=1);

namespace MeiliSearch\Search;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class SearchResult implements Countable, IteratorAggregate
{
    /**
     * @var array<int, array<string, mixed>>
     */
    private array $hits;

    /**
     * `nbHits` is the attributes returned by the Meilisearch server
     * and its value will not be modified by the methods in this class.
     * Please, use `hitsCount` if you want to know the real size of the `hits` array at any time.
     */
    private int $nbHits;

    private int $hitsCount;
    private bool $exhaustiveNbHits;
    private int $offset;
    private int $limit;
    private int $processingTimeMs;

    private string $query;
    private ?bool $exhaustiveFacetsCount;

    /**
     * @var array<string, mixed>
     */
    private array $facetsDistribution;

    /**
     * @var array<string, mixed>
     */
    private array $raw;

    public function __construct(array $body)
    {
        $this->hits = $body['hits'] ?? [];
        $this->offset = $body['offset'];
        $this->limit = $body['limit'];
        $this->nbHits = $body['nbHits'];
        $this->hitsCount = \count($body['hits']);
        $this->exhaustiveNbHits = $body['exhaustiveNbHits'] ?? false;
        $this->processingTimeMs = $body['processingTimeMs'];
        $this->query = $body['query'];
        $this->exhaustiveFacetsCount = $body['exhaustiveFacetsCount'] ?? null;
        $this->facetsDistribution = $body['facetsDistribution'] ?? [];
        $this->raw = $body;
    }

    /**
     * Return a new {@see SearchResult} instance.
     *
     * The $options parameter is an array, and the following keys are accepted:
     * - transformFacetsDistribution (callable)
     * - transformHits (callable)
     *
     * The method does NOT trigger a new search.
     *
     * @return SearchResult
     */
    public function applyOptions($options): self
    {
        if (\array_key_exists('transformHits', $options) && \is_callable($options['transformHits'])) {
            $this->transformHits($options['transformHits']);
        }
        if (\array_key_exists('transformFacetsDistribution', $options) && \is_callable($options['transformFacetsDistribution'])) {
            $this->transformFacetsDistribution($options['transformFacetsDistribution']);
        }

        return $this;
    }

    public function transformHits(callable $callback): self
    {
        $this->hits = $callback($this->hits);
        $this->hitsCount = \count($this->hits);

        return $this;
    }

    public function transformFacetsDistribution(callable $callback): self
    {
        $this->facetsDistribution = $callback($this->facetsDistribution);

        return $this;
    }

    public function getHit(int $key, $default = null)
    {
        return $this->hits[$key] ?? $default;
    }

    /**
     * @return array<int, array>
     */
    public function getHits(): array
    {
        return $this->hits;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getHitsCount(): int
    {
        return $this->hitsCount;
    }

    public function count(): int
    {
        return $this->hitsCount;
    }

    public function getNbHits(): int
    {
        return $this->nbHits;
    }

    public function getExhaustiveNbHits(): bool
    {
        return $this->exhaustiveNbHits;
    }

    public function getProcessingTimeMs(): int
    {
        return $this->processingTimeMs;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getExhaustiveFacetsCount(): ?bool
    {
        return $this->exhaustiveFacetsCount;
    }

    /**
     * @return array<string, mixed>
     */
    public function getFacetsDistribution(): array
    {
        return $this->facetsDistribution;
    }

    /**
     * Return the original search result.
     *
     * @return array<string, mixed>
     */
    public function getRaw(): array
    {
        return $this->raw;
    }

    public function toArray(): array
    {
        return [
            'hits' => $this->hits,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'nbHits' => $this->nbHits,
            'hitsCount' => $this->hitsCount,
            'exhaustiveNbHits' => $this->exhaustiveNbHits,
            'processingTimeMs' => $this->processingTimeMs,
            'query' => $this->query,
            'exhaustiveFacetsCount' => $this->exhaustiveFacetsCount,
            'facetsDistribution' => $this->facetsDistribution,
        ];
    }

    public function toJSON(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->hits);
    }
}
