<?php
/**
 * Created By: Ide Peter
 * PC: Petide Systems
 * Project: Peres Bakeries Limited
 * Class Name: CreateExpenditureModel.php
 * Date Created: 08/11/2024
 * Time Created: 7:40 PM
 */

 namespace App\Docs;

 /**
  *
  * @package peresbackeries-api
  * @author  Peter Ide <petideenterprise@gmail.com>
  *
  * @OA\Schema(
  *     title="CreateExpenditureModel",
  *     description="Peres Bakeries Expenditure management Model",
  *     @OA\Xml(
  *         name="CreateExpenditureModel"
  *     )
  * )
  */
  class CreateExpenditureModel
  {
    /**
     * @OA\Property(
     *          title="Item",
     *          example="Flour"
     *      ),
     *
     * @var string
     */
    private $item;

    /**
     * @OA\Property(
     *      title="Amount",
     *      example="5000"
     * ),
     *
     * @var string
     *
     */
    private $amount;
  }