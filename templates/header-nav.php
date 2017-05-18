<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($data['categories'] as $category): ?>
            <li class="nav__item">
                <a href=""><?=$category['name'];?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
