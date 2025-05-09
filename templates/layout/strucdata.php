<?php if ($template == 'product/product_detail') { ?>
    <!-- Product -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "Product",
            "name": "<?= @$rowDetail['name' . $lang] ?>",
            "image": [
                "<?= $configBase . UPLOAD_PRODUCT_L . @$rowDetail['photo'] ?>"
            ],
            "description": "<?= $seo->get('description') ?>",
            "sku": "SP0<?= @$rowDetail['id'] ?>",
            "mpn": "925872",
            "brand": {
                "@type": "Brand",
                "name": "<?= (!empty($productList['name' . $lang])) ? $productList['name' . $lang] : $setting['name' . $lang] ?>"
            },
            "review": {
                "@type": "Review",
                "reviewRating": {
                    "@type": "Rating",
                    "ratingValue": "5",
                    "bestRating": "5"
                },
                "author": {
                    "@type": "Person",
                    "name": "<?= @$setting['name' . $lang] ?>"
                }
            },
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "4.4",
                "reviewCount": "89"
            },
            "offers": {
                "@type": "Offer",
                "url": "<?= $func->getCurrentPageURL_CANO() ?>",
                "priceCurrency": "VND",
                "price": "<?= @$rowDetail['regular_price'] ?>",
                "priceValidUntil": "2020-11-05",
                "itemCondition": "https://schema.org/NewCondition",
                "availability": "https://schema.org/InStock",
                "seller": {
                    "@type": "Organization",
                    "name": "Executive Objects"
                }
            }
        }
    </script>
<?php } else if ($template == 'news/news_detail') { ?>
    <!-- News -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NewsArticle",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "https://google.com/article"
            },
            "headline": "<?= @$rowDetail['name' . $lang] ?>",
            "image": [
                "<?= $configBase . UPLOAD_NEWS_L . @$rowDetail['photo'] ?>"
            ],
            "datePublished": "<?= date('Y-m-d', @$rowDetail['date_created']) ?>",
            "dateModified": "<?= date('Y-m-d', @$rowDetail['date_updated']) ?>",
            "author": {
                "@type": "Person",
                "name": "<?= @$setting['name' . $lang] ?>"
            },
            "publisher": {
                "@type": "Organization",
                "name": "Google",
                "logo": {
                    "@type": "ImageObject",
                    "url": "<?= $configBase . UPLOAD_PHOTO_L . @$logo['photo'] ?>"
                }
            },
            "description": "<?= $seo->get('description') ?>"
        }
    </script>
<?php } else if ($template == 'static/static') { ?>
    <!-- Static -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NewsArticle",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "https://google.com/article"
            },
            "headline": "<?= @$static['name' . $lang] ?>",
            "image": [
                "<?= $configBase . UPLOAD_NEWS_L . @$static['photo'] ?>"
            ],
            "datePublished": "<?= date('Y-m-d', @$static['date_created']) ?>",
            "dateModified": "<?= date('Y-m-d', @$static['date_updated']) ?>",
            "author": {
                "@type": "Person",
                "name": "<?= @$setting['name' . $lang] ?>"
            },
            "publisher": {
                "@type": "Organization",
                "name": "Google",
                "logo": {
                    "@type": "ImageObject",
                    "url": "<?= $configBase . UPLOAD_PHOTO_L . @$logo['photo'] ?>"
                }
            },
            "description": "<?= $seo->get('description') ?>"
        }
    </script>
<?php } else { ?>
    <!-- General -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "<?= @$setting['name' . $lang] ?>",
            "url": "<?= $configBase ?>",
            "sameAs": [
                <?php if (!empty($social)) {
                    $sum_social = count($social);
                    foreach ($social as $key => $value) { ?> "<?= @$value['link'] ?>"
                        <?= (($key + 1) < $sum_social) ? ',' : '' ?>
                <?php }
                } ?>
            ],
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "<?= $optsetting['address'] ?>",
                "addressRegion": "Ho Chi Minh",
                "postalCode": "70000",
                "addressCountry": "vi"
            }
        }
    </script>
<?php } ?>