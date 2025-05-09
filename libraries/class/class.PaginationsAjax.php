<?php
class PaginationsAjax
{
    public $perpage;

    function __construct()
    {
        $this->perpage = 1;
    }

    function getAllPageLinks($count, $href, $elShow)
    {
        $output = '';

        if (empty($_GET["p"])) $_GET["p"] = 1;

        if ($this->perpage != 0)
            $pages = ceil($count / $this->perpage);

        if ($pages > 1) {
            if ($_GET["p"] == 1)
                $output = $output . '<a class="first disabled">First</a><a class="prev disabled">Prev</a>';
            else
                $output = $output . '<a class="first" onclick="loadPaging(\'' . $href . (1) . '\',\'' . $elShow . '\')" >First</a><a class="prev" onclick="loadPaging(\'' . $href . ($_GET["p"] - 1) . '\',\'' . $elShow . '\')" >Prev</a>';

            if (($_GET["p"] - 3) > 0) {
                if ($_GET["p"] == 1)
                    $output = $output . '<a id=1 class="current">1</a>';
                else
                    $output = $output . '<a onclick="loadPaging(\'' . $href . '1\',\'' . $elShow . '\')" >1</a>';
            }
            if (($_GET["p"] - 3) > 1) {
                $output = $output . '<a class="dot">...</a>';
            }

            for ($i = ($_GET["p"] - 2); $i <= ($_GET["p"] + 2); $i++) {
                if ($i < 1) continue;
                if ($i > $pages) break;
                if ($_GET["p"] == $i)
                    $output = $output . '<a id=' . $i . ' class="current">' . $i . '</a>';
                else
                    $output = $output . '<a onclick="loadPaging(\'' . $href . $i . '\',\'' . $elShow . '\')" >' . $i . '</a>';
            }

            if (($pages - ($_GET["p"] + 2)) > 1) {
                $output = $output . '<a class="dot">...</a>';
            }
            if (($pages - ($_GET["p"] + 2)) > 0) {
                if ($_GET["p"] == $pages)
                    $output = $output . '<a id=' . ($pages) . ' class="current">' . ($pages) . '</a>';
                else
                    $output = $output . '<a onclick="loadPaging(\'' . $href .  ($pages) . '\',\'' . $elShow . '\')" >' . ($pages) . '</a>';
            }

            if ($_GET["p"] < $pages)
                $output = $output . '<a class="next" onclick="loadPaging(\'' . $href . ($_GET["p"] + 1) . '\',\'' . $elShow . '\')" >Next</a><a class="last" onclick="loadPaging(\'' . $href . ($pages) . '\',\'' . $elShow . '\')" >Last</a>';
            else
                $output = $output . '<a class="next disabled">Next</a><a class="last disabled">Last</a>';
        }

        return $output;
    }

    function getPrevNext($count, $href, $elShow)
    {
        $output = '';

        if (empty($_GET["p"])) $_GET["p"] = 1;

        if ($this->perpage != 0)
            $pages  = ceil($count / $this->perpage);

        if ($pages > 1) {
            if ($_GET["p"] == 1)
                $output = $output . '<a class="prev disabled">Prev</a>';
            else
                $output = $output . '<a class="prev" onclick="loadPaging(\'' . $href . ($_GET["p"] - 1) . '\',\'' . $elShow . '\')" >Prev</a>';

            if ($_GET["p"] < $pages)
                $output = $output . '<a class="next" onclick="loadPaging(\'' . $href . ($_GET["p"] + 1) . '\',\'' . $elShow . '\')" >Next</a>';
            else
                $output = $output . '<a class="next disabled">Next</a>';
        }

        return $output;
    }
}
