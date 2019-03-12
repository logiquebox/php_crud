<?php
echo "<ul class='pagination'>";
// first page button
        if($page>1){
            $prev_page = $page - 1;
            echo "<li class='page-item'>";
            echo "<a class = 'page-link' href='{$page_url}page={$prev_page}'>";
            echo "<span style='margin:0.5em;'>&laquo;</span>";
            echo "</a>";
            echo "</li>";
}

// click-able page numbers

// find out total pages
$total_pages = ceil($total_rows / $records_per_page);

// range of num links to show
$range = 1;

// display links to 'range of pages' around 'current page'
$initial_num = $page - $range;
$condition_limit_num = ($page + $range)  + 1;

for ($x=$initial_num; $x<$condition_limit_num; $x++) {

    // be sure '$x is greater than 0' AND 'less than or equal to the $total_pages'
    if (($x > 0) && ($x <= $total_pages)) {

        // current page
        if ($x == $page) {
            echo "<li class='page-item active'>";
            echo "<a class='page-link' href='javascript::void();'>{$x}</a>";
            echo "</li>";
        }

        // not current page
        else {
            echo "<li class='page-item'>";
            echo " <a class='page-link' href='{$page_url}page={$x}'>{$x}</a> ";
            echo "</li>";
        }
    }
}

// last page button
if($page<$total_pages){
    $next_page = $page + 1;

    echo "<li class='page-item'>";
    echo "<a class='page-link' href='{$page_url}page={$next_page}'>";
    echo "<span style='margin:0.5em;'>&raquo;</span>";
    echo "</a>";
    echo "</li>";
}

echo "</ul>";
?>