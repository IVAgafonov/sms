<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Helper;

use Zend\View\Helper\AbstractHelper;

class PaginationUserFilteredHelper extends AbstractHelper
{
    private $resultsPerPage;
    private $totalResults;
    private $results;
    private $baseId;
    private $filter;
    private $baseUrl;
    private $paging;
    private $page;

    public function __invoke($pagedResults, $page, $filter, $baseUrl, $resultsPerPage = 10)
    {
        $this->resultsPerPage = $resultsPerPage;
        $this->totalResults = $pagedResults->count();
        $this->results = $pagedResults;
        $this->filter = $filter;
        $this->baseUrl = $baseUrl;
        $this->page = $page;

        return $this->generatePaging();
    }

    private function generatePaging()
    {
        # Get total page count
        $pages = ceil($this->totalResults / $this->resultsPerPage);

        # Don't show pagination if there's only one page
        if ($pages == 1) {
            return;
        }
        
        #if pages count <= 5
        if ($pages <= 5 ) {
            # Show back to first page if not first page
            if ($this->page != 1) {
                $this->paging = "<a href='". $this->baseUrl . "/1";
                if ($this->filter != '') {
                    $this->paging .= "/".$this->filter;
                }
                $this->paging .= "'><</a>";
            }

            # Create a link for each page
            $pageCount = 1;
            while ($pageCount <= $pages) {
                $this->paging .= "<a href='" .$this->baseUrl. "/" . $pageCount;
                if ($this->filter != '') {
                    $this->paging .= "/".$this->filter;
                }
                $this->paging .= "'";
                if ($pageCount == $this->page) {
                    $this->paging .= "class='current'";
                }
                $this->paging .= ">" . $pageCount . "</a>";
                $pageCount++;
            }

            # Show go to last page option if not the last page
            if ($this->page != $pages) {
                $this->paging .= "<a href='" . $this->baseUrl . "/". $pages;
                if ($this->filter != '') {
                    $this->paging .= "/".$this->filter;
                }
                $this->paging .= "'>></a>";
            }
        } else {
            # Show back to first page if not first page
            if ($this->page != 1) {
                $prev = $this->page-1;
                $this->paging = "<a href='". $this->baseUrl . "/". $prev;
                if ($this->filter != '') {
                    $this->paging .= "/".$this->filter;
                }
                $this->paging .= "'";
                $this->paging .= " class='long'";    
                $this->paging .= "><</a>";
            }

            # Create a link for current page
            $this->paging .= "<a href='" .$this->baseUrl. "/" . $this->page;
            if ($this->filter != '') {
                $this->paging .= "/".$this->filter;
            }
            $this->paging .= "'";
            $this->paging .= " class='long current'";

            $this->paging .= ">" . $this->page . "</a>";

            # Show go to last page option if not the last page
            if ($this->page != $pages) {
                $next = $this->page+1;
                $this->paging .= "<a href='" . $this->baseUrl . "/" . $next;
                if ($this->filter != '') {
                    $this->paging .= "/".$this->filter;
                }
                $this->paging .= "'";
                $this->paging .= " class='long'";    
                $this->paging .= ">></a>";
            }
        }
        return $this->paging;
    }
}

