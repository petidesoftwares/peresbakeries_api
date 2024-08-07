<?php
/**
 * Created By: Ide Peter
 * PC: Petide Systems
 * Project: Peres Bakeries Limited
 * Class Name: CreateDailySalesModel.php
 * Date Created: 08/05/2024
 * Time Created: 11:38 PM
 */

 namespace App\Docs;

 /**
 *
 * @package Peresbakeries_api
 * @author  Peter Ide <petideenterprise@gmail.com>
 *
 * @OA\Schema(
 *     title="CreateDailySaleModel",
 *     description="Pares Bakeries Limited Daily Sales Model",
 *     @OA\Xml(
 *         name="CreateDailySaleModel"
 *     )
 * )
 */

 class CreateDailySaleModel
 {
    /**
     * @OA\Property(
     *          title="Date",
     *          example="dd/mm/yyyy"
     *      ),
     *
     * @var string
     */
    private $date;

 }