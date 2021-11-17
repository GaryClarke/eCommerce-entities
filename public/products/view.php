<?php

require_once dirname(__DIR__, 2) . '/bootstrap.php';

/** @var \Doctrine\ORM\EntityManager $em */
$em = $entityManager;

$productId = $_GET['id'];

/** @var \App\Entity\Product $product */
$product = $em->getRepository(\App\Entity\Product::class)->find($productId);

$title = $product->getName();

include dirname(__DIR__, 1) . '/includes/site-header.php'
?>

<!-- Begin page content -->
<main class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5"><span style="color: red">$<?= number_format($product->getPrice() / 100, 2) ?></span> <?= $product->getName() ?></h1>
        <p class="lead"><?= $product->getDescription() ?></p>
        <a href="/products/single-product-checkout.php?id=<?= $product->getId() ?>" class="btn btn-primary">BUY IT NOW</a>
    </div>
</main>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <span class="text-muted">Place sticky footer content here.</span>
    </div>
</footer>


<script src="/docs/5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>
</html>
