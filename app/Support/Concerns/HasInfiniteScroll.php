<?php

namespace App\Support\Concerns;

trait HasInfiniteScroll
{
    public int $limit = 9;

    public bool $hasMore = true;

    abstract protected function totalItemsCount(): int;

    public function mountHasInfiniteScroll(): void
    {
        $this->updateHasMore();
    }

    public function loadMore(): void
    {
        if (! $this->hasMore) {
            return;
        }

        $this->limit += 9;

        $this->updateHasMore();
    }

    protected function updateHasMore(): void
    {
        $this->hasMore =
            $this->totalItemsCount() > $this->limit;
    }
}
