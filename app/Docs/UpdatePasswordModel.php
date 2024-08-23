<?php
/**
 * Created By: Ide Peter
 * PC: Petide Systems
 * Project: Peres Bakeries Limited
 * Class Name: UpdatePasswordModel.php
 * Date Created: 08/23/2024
 * Time Created: 08:39 AM
 */

 namespace App\Docs;

 /**
 *
 * @package Peresbakeries_api
 * @author  Peter Ide <petideenterprise@gmail.com>
 *
 * @OA\Schema(
 *     title="UpdatePasswordModel",
 *     description="Pares Bakeries Limited Update Password Model",
 *     @OA\Xml(
 *         name="UpdatePasswordModel"
 *     )
 * )
 */

 class UpdatePasswordModel {

    /**
     * @OA\Property(
     *          title="New Password",
     *          example="xxxxxxxxx",
     *      ),
     *
     * @var string
     */
    private $newPassword;
 }