<?php

namespace Source\Support;

/**
 * JSON-PHP | Class Paginator
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Support
 */
class Pager
{
    /** @var int */
    private $page;

    /** @var int */
    private $pages;

    /** @var int */
    private $rows;

    /** @var int */
    private $limit;

    /** @var int */
    private $offset;

    /** @var int */
    private $range;

    /** @var string */
    private $link;

    /** @var string */
    private $title;

    /*** @var string */
    private $classItems;

    /** @var string */
    private $hash;

    /** @var array */
    private $first;

    /** @var array */
    private $last;

    /**
     * Paginator constructor.
     * @param string|null $link
     * @param string|null $title
     * @param array|null $first
     * @param array|null $last
     */
    public function __construct(string $link = null, string $title = null, array $first = null, array $last = null)
    {
        $this->link = ($link ?? "?page=");
        $this->title = ($title ?? "Página");
        $this->first = ($first ?? ["Primeira página", "<<"]);
        $this->last = ($last ?? ["Última página", ">>"]);
    }

    /**
     * @param int $rows
     * @param int $limit
     * @param int|null $page
     * @param int $range
     * @param string|null $hash
     */
    public function pager(int $rows, int $limit = 10, int $page = null, int $range = 2, string $hash = null): void
    {
        $this->rows = $this->toPositive($rows);
        $this->limit = $this->toPositive($limit);
        $this->range = $this->toPositive($range);
        $this->pages = (int)ceil($this->rows / $this->limit);
        $this->page = ($page <= $this->pages ? $this->toPositive($page) : $this->pages);

        $this->offset = (($this->page * $this->limit) - $this->limit >= 0 ? ($this->page * $this->limit) - $this->limit : 0);
        $this->hash = (!empty($hash) ? "#{$hash}" : null);

        if ($this->rows && $this->offset >= $this->rows) {
            header("Location: {$this->link}" . ceil($this->rows / $this->limit));
            exit;
        }
    }

    /**
     * @return int
     */
    public function limit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function offset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function page()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function pages()
    {
        return $this->pages;
    }

    /**
     * @param string|null $mainCssClass
     * @param String|null $cssItemCass
     * @param bool $fixedFirstAndLastPage
     * @return null|string
     */
    public function render(
        string $mainCssClass = null,
        string $cssItemCass = null,
        bool $fixedFirstAndLastPage = true
    ): ?string {
        $classContainer = $mainCssClass ?? "pagination justify-content-end";
        $this->classItems = $cssItemCass ?? "page";

        if ($this->rows > $this->limit):
            $paginator = "<nav>";
        $paginator .= "<ul class=\"{$classContainer}\">";
        $paginator .= $this->firstPage($fixedFirstAndLastPage);
        $paginator .= $this->beforePages();
        $paginator .= "<li class=\"{$this->classItems}-item active\"><span class=\"{$this->classItems}-link\">{$this->page}</span></li>";
        $paginator .= $this->afterPages();
        $paginator .= $this->lastPage($fixedFirstAndLastPage);
        $paginator .= "</ul>";
        $paginator .= "</nav>";
        return $paginator;
        endif;

        return null;
    }

    /**
     * @return null|string
     */
    private function beforePages(): ?string
    {
        $before = null;
        for ($iPag = $this->page - $this->range; $iPag <= $this->page - 1; $iPag++):
            if ($iPag >= 1):
                $before .= "<li class=\"{$this->classItems}-item\"><a class='{$this->classItems}-link' title=\"{$this->title} {$iPag}\" href=\"{$this->link}{$iPag}{$this->hash}\">{$iPag}</a></li>";
        endif;
        endfor;

        return $before;
    }

    /**
     * @return string|null
     */
    private function afterPages(): ?string
    {
        $after = null;
        for ($dPag = $this->page + 1; $dPag <= $this->page + $this->range; $dPag++):
            if ($dPag <= $this->pages):
                $after .= "<li class=\"{$this->classItems}-item\"><a class='{$this->classItems}-link' title=\"{$this->title} {$dPag}\" href=\"{$this->link}{$dPag}{$this->hash}\">{$dPag}</a></li>";
        endif;
        endfor;

        return $after;
    }

    /**
     * @param bool $fixedFirstAndLastPage
     * @return string|null
     */
    public function firstPage(bool $fixedFirstAndLastPage = true): ?string
    {
        if ($fixedFirstAndLastPage || $this->page != 1) {
            $tag = "a";
            $disabled = "";
            if ($this->page == 1) {
                $tag = "span";
                $disabled = "disabled";
            }
            return "<li class=\"{$this->classItems}-item {$disabled}\"><{$tag} class=\"{$this->classItems}-link\" title=\"{$this->first[0]}\" href=\"{$this->link}1{$this->hash}\">{$this->first[1]}</{$tag}></li>";
        }
        return null;
    }

    /**
     * @param bool $fixedFirstAndLastPage
     * @return string|null
     */
    public function lastPage(bool $fixedFirstAndLastPage = true): ?string
    {
        if ($fixedFirstAndLastPage || $this->page != $this->pages) {
            $tag = "a";
            $disabled = "";
            if ($this->page == $this->pages) {
                $tag = "span";
                $disabled = "disabled";
            }
            return "<li class=\"{$this->classItems}-item {$disabled}\"><{$tag} class='{$this->classItems}-link' title=\"{$this->last[0]}\" href=\"{$this->link}{$this->pages}{$this->hash}\">{$this->last[1]}</{$tag}></li>";
        }
        return null;
    }

    /**
     * @param $number
     * @return int
     */
    private function toPositive($number): int
    {
        return ($number >= 1 ? $number : 1);
    }
}
