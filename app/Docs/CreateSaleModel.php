<?php
/**
 * Created By: Ide Peter
 * PC: Petide Systems
 * Project: Peres Bakeries Limited
 * Class Name: CreateSalesModel.php
 * Date Created: 07/21/2024
 * Time Created: 09:35 PM
 */

 namespace App\Docs;

 /**
 *
 * @package Peresbakeries_api
 * @author  Peter Ide <petideenterprise@gmail.com>
 *
 * @OA\Schema(
 *     title="CreateSaleModel",
 *     description="Pares Bakeries Limited Sales Model",
 *     @OA\Xml(
 *         name="CreateSaleModel"
 *     )
 * )
 */

 class CreateSaleModel
 {
    /**
     * @OA\Property(
     *          title="Product Id",
     *          example="xxxxxxxxxxxxxxxxx"
     *      ),
     *
     * @var string
     */
    private $product_id;

    /**
     * @OA\Property(
     *          title="Product unit price",
     *          example="200"
     *      ),
     *
     * @var string
     */
    private $price;

    /**
     * @OA\Property(
     *          title="Product quantity",
     *          example="4"
     *      ),
     *
     * @var string
     */
    private $quantity;

    /**
     * @OA\Property(
     *          title="Amount for Total Units",
     *          example=800
     *      ),
     *
     * @var string
     */
    private $amount;

 }