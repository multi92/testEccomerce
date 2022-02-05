<div class="left_product_list_con">
    <div class="products_title_right"><?php echo ucfirst($data['translations']['proizvodi']) ?></div>
    <div class="products_list_right">
        <ul>
            <?php
            foreach ($data['menuprods'] as $prod) { ?>
                <a href="proizvod/<?php echo $prod->productid ?>">
                    <li>
                        <?php echo $prod->name; ?>
                    </li>
                </a>
                <?php
            }
            ?>
            <?php
            foreach ($data['menuprods'] as $prod) { ?>
                <a href="proizvod/<?php echo $prod->productid ?>">
                    <li>
                        <?php echo $prod->name; ?>
                    </li>
                </a>
                <?php
            }
            ?>

        </ul>
    </div>

</div>
