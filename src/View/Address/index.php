<?php
/** @var \Bone\Address\Entity\Address[] $addresss */

use Del\Icon;

?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= Icon::SHIELD ?>&nbsp;&nbsp;Address Admin</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                    <li class="breadcrumb-item active">Address Admin</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col"><?= $paginator ?></div>
            <div class="col">
                <div class="input-group">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="col"><a href="/admin/address/create" class="btn btn-primary pull-right"><?= Icon::ADD ?> Add an Address</a></div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline table-responsive p-0">
                    <table class="table card-body table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Postcode</th>
                            <th>Lat/Lng</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (count($addresss)) {
                            foreach ($addresss as $address) { ?>
                                <tr>
                                    <td><a href="/admin/address/<?= $address->getId() ?>"><?= $address->getId() ?></a></td>
                                    <td><?= $address->getAdd1() ?></td>
                                    <td><?= $address->getCity() ?></td>
                                    <td><?= $address->getPostcode() ?></td>
                                    <td><?= $address->getLat() && $address->getLng() ? $address->getLat() . ', ' .$address->getLng() : ''?></td>
                                    <td><a href="/admin/address/edit/<?= $address->getId() ?>"><?= Icon::EDIT ;?></a></td>
                                    <td><a href="/admin/address/delete/<?= $address->getId() ?>"><?= Icon::REMOVE ;?></a></td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="5" class="text-danger">No records have been found in the database.</td>
                            </tr>
                        <?php } ?>
    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
