<?php

use Del\Icon;

/** @var \Bone\Address\Entity\Address $address */
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= Icon::SHIELD ?>&nbsp;&nbsp;Address Admin - View</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                    <li class="breadcrumb-item"><a href="/admin/address">Address</a></li>
                    <li class="breadcrumb-item active">View Address</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card card-primary card-outline col-md-12">
                    <div class="card-body p-10">
                        <div class="mailbox-read-info">
                            <h2><?= $address->getAdd1() ?></h2>
                        </div>
                        <div class="mailbox-read-messagex">
                            <p class="lead">
                                <?= $address->getAdd1() ?>
                                <?= $address->getAdd2() ? '<br>' . $address->getAdd2() : '' ?>
                                <?= $address->getAdd3() ? '<br>' . $address->getAdd3() : '' ?><br>
                                <?= $address->getCity() . ' ' . $address->getPostcode() ?><br>
                                <?= $address->getCountry() ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="float-right">
                        <a href="/admin/address" class="btn btn-default"><i class="fa fa-backward"></i> Back</a>
                        <a href="/admin/address/edit/<?= $address->getId() ?>"
                           class="btn btn-primary"><?= Icon::EDIT; ?> Edit</a>
                    </div>
                    <a href="/admin/address/delete/<?= $address->getId() ?>" class="btn btn-danger"><i
                                class="fa fa-trash"></i> Delete</a>
                </div>
            </div>
            <div class="col">
                <img src="//via.placeholder.com/600x450?text=Put a Map Here" alt=""/>
            </div>
        </div>
    </div>
</section>
