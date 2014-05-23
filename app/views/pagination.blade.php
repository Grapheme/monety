<?php
	$presenter = new Illuminate\Pagination\PaginationClass($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
<ul class="pagination">
	{{ $presenter->render() }}
</ul>
<?php endif; ?>