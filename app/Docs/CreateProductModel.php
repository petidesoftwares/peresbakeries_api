<?php
/**
 * Created By: Ide Peter
 * PC: Petide Systems
 * Project: Peres Bakeries Limited
 * Class Name: CreateProductModel.php
 * Date Created: 07/20/2024
 * Time Created: 09:01 PM
 */

 namespace App\Docs;

 /**
 *
 * @package Peresbakeries_api
 * @author  Peter Ide <petideenterprise@gmail.com>
 *
 * @OA\Schema(
 *     title="CreateProductModel",
 *     description="Pares Bakeries Limited Login Model",
 *     @OA\Xml(
 *         name="CreateProductModel"
 *     )
 * )
 */

 class CreateProductModel
 {
    /**
     * @OA\Property(
     *          title="Product name",
     *          example="Sardine Bread"
     *      ),
     *
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *          title="Product price",
     *          example="200"
     *      ),
     *
     * @var string
     */
    private $price;

    /**
     * @OA\Property(
     *          title="Product description",
     *          example="Jumbo size sardine bread"
     *      ),
     *
     * @var string
     */
    private $description;

    /**
     * @OA\Property(
     *          title="Product shape",
     *          example="Cuboid"
     *      ),
     *
     * @var string
     */
    private $shape;

    /**
     * @OA\Property(
     *          title="Product size",
     *          example="10cm X 10cm X 25cm"
     *      ),
     *
     * @var string
     */
    private $size;

    /**
     * @OA\Property(
     *          title="Product quantity in stock",
     *          example="300"
     *      ),
     *
     * @var string
     */
    private $stock;
 }