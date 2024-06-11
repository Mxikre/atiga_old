<nav class="d-flex justify-content-end" aria-label="Page navigation">
    <ul class="pagination">
        <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" tabindex="-1" aria-disabled="true" style="background-color: var(--secondary); color: white;">Previous</a>
        </li>
        <?php
        // Tampilkan tautan navigasi
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<li class='page-item" . ($i == $currentPage ? " active' aria-current='page'" : "'") . ">";
            echo "<a class='page-link mx-2' href='?page=$i' style='background-color: var(--primary); border: none;'>$i</a>";
            echo "</li>";
        }
        ?>
        <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
            <?php if ($currentPage < $totalPages) : ?>
                <a class="page-link bg-warning text-muted" href="?page=<?php echo $currentPage + 1; ?>">Next</a>
            <?php else : ?>
                <span class="page-link bg-warning text-muted disabled">Next</span>
            <?php endif; ?>
        </li>
    </ul>
</nav>