<?php

require_once dirname(__DIR__, 2) . '/bootstrap.php';

/** @var \Doctrine\ORM\EntityManager $em */
$em = $entityManager;

$productId = $_GET['id'];

/** @var \App\Entity\Product $product */
$product = $em->getRepository(\App\Entity\Product::class)->find($productId);

$title = 'Place Order';

include dirname(__DIR__, 1) . '/includes/site-header.php'

?>

<div class="container" style="max-width: 960px; padding-top: 50px">
    <main>
        <div class="py-5 text-center">
            <h2>Checkout form</h2>
            <p class="lead">Below is an example form built entirely with Bootstrap’s form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p>
        </div>

        <div class="row g-5">
            <div class="col-md-5 col-lg-4 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your cart</span>
                    <span class="badge bg-primary rounded-pill">3</span>
                </h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">Product name</h6>
                            <small class="text-muted">Brief description</small>
                        </div>
                        <span class="text-muted">$12</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">Second product</h6>
                            <small class="text-muted">Brief description</small>
                        </div>
                        <span class="text-muted">$8</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">Third item</h6>
                            <small class="text-muted">Brief description</small>
                        </div>
                        <span class="text-muted">$5</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <div class="text-success">
                            <h6 class="my-0">Promo code</h6>
                            <small>EXAMPLECODE</small>
                        </div>
                        <span class="text-success">−$5</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (USD)</span>
                        <strong>$20</strong>
                    </li>
                </ul>

                <form class="card p-2">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Promo code">
                        <button type="submit" class="btn btn-secondary">Redeem</button>
                    </div>
                </form>
            </div>


            <!-- BILLING ADDRESS -->
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Billing address</h4>
                <form class="needs-validation" method="post"
                      action="/orders/place-order.php" novalidate>

                    <input type="hidden" name="product[id]" value="<?= $product->getId() ?>"/>
                    <input type="hidden" name="product[price]" value="<?= $product->getPrice() ?>"/>

                    <div class="row g-3">

                        <div class="col-12">
                            <label for="name" class="form-label">name</label>
                            <input type="text" class="form-control" id="name"
                                   name="address[name]"
                                   placeholder="" value="" required>
                            <div class="invalid-feedback">
                                Valid name is required.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
                            <input type="email" class="form-control" id="email" placeholder="you@example.com">
                            <div class="invalid-feedback">
                                Please enter a valid email address for shipping updates.
                            </div>
                        </div>

                        <!-- STREET ADDRESS -->
                        <div class="col-12">
                            <label for="street-address" class="form-label">Street Address</label>
                            <input type="text" class="form-control" id="street-address"
                                   name="address[street-address]"
                                   placeholder="1234 Main St" required>
                            <div class="invalid-feedback">
                                Please enter your shipping address.
                            </div>
                        </div>

                        <!-- CITY -->
                        <div class="col-12">
                            <label for="city" class="form-label">City <span class="text-muted">(Optional)</span></label>
                            <input type="text" class="form-control" id="city"
                                   name="address[city]"
                                   placeholder="City">
                        </div>

                        <div class="col-md-5">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country"
                                   name="address[country]"
                                   placeholder="Country">
                            <div class="invalid-feedback">
                                Please enter a valid country.
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="zip" class="form-label">Zip</label>
                            <input type="text" class="form-control" id="zip"
                                   name="address[zip]"
                                   placeholder="" required>
                            <div class="invalid-feedback">
                                Zip code required.
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="same-address">
                        <label class="form-check-label" for="same-address">Shipping address is the same as my billing address</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="save-info">
                        <label class="form-check-label" for="save-info">Save this information for next time</label>
                    </div>

                    <hr class="my-4">

                    <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
                </form>
            </div>
        </div>
    </main>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017–2021 Company Name</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Privacy</a></li>
            <li class="list-inline-item"><a href="#">Terms</a></li>
            <li class="list-inline-item"><a href="#">Support</a></li>
        </ul>
    </footer>
</div>


<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script type="text/javascript">
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()

</script>
</body>
</html>



















<!--<h4 class="mb-3">Payment</h4>-->
<!---->
<!--<div class="my-3">-->
<!--    <div class="form-check">-->
<!--        <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>-->
<!--        <label class="form-check-label" for="credit">Credit card</label>-->
<!--    </div>-->
<!--    <div class="form-check">-->
<!--        <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>-->
<!--        <label class="form-check-label" for="debit">Debit card</label>-->
<!--    </div>-->
<!--    <div class="form-check">-->
<!--        <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>-->
<!--        <label class="form-check-label" for="paypal">PayPal</label>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!--<div class="row gy-3">-->
<!--    <div class="col-md-6">-->
<!--        <label for="cc-name" class="form-label">Name on card</label>-->
<!--        <input type="text" class="form-control" id="cc-name" placeholder="" required>-->
<!--        <small class="text-muted">Full name as displayed on card</small>-->
<!--        <div class="invalid-feedback">-->
<!--            Name on card is required-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div class="col-md-6">-->
<!--        <label for="cc-number" class="form-label">Credit card number</label>-->
<!--        <input type="text" class="form-control" id="cc-number" placeholder="" required>-->
<!--        <div class="invalid-feedback">-->
<!--            Credit card number is required-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div class="col-md-3">-->
<!--        <label for="cc-expiration" class="form-label">Expiration</label>-->
<!--        <input type="text" class="form-control" id="cc-expiration" placeholder="" required>-->
<!--        <div class="invalid-feedback">-->
<!--            Expiration date required-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div class="col-md-3">-->
<!--        <label for="cc-cvv" class="form-label">CVV</label>-->
<!--        <input type="text" class="form-control" id="cc-cvv" placeholder="" required>-->
<!--        <div class="invalid-feedback">-->
<!--            Security code required-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!--<hr class="my-4">-->

