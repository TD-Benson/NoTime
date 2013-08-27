<?php

global $searchFormIndex;

if (isset($searchFormIndex))
	$searchFormIndex++;
else
	$searchFormIndex = 0;

?>
<div class="theme-search-icon"></div>
<form method="get" class="theme-search-form" action="<?php echo home_url(); ?>" name="search-form-<?php echo $searchFormIndex; ?>">
	<input type="text" value="<?php the_search_query(); ?>" name="s">
	<input type="submit" value="&nbsp;">
</form>