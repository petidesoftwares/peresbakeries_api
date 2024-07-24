<?php
/**
 * Created By: Ide Peter
 * PC: Petide Systems
 * Project: Peres Bakeries Limited
 * Class Name: StaffLoginModel.php
 * Date Created: 07/14/2024
 * Time Created: 7:40 AM
 */

namespace App\Docs;

/**
 *
 * @package peresbackeries-api
 * @author  Peter Ide <petideenterprise@gmail.com>
 *
 * @OA\Schema(
 *     title="StudentLoginModel",
 *     description="Peres Bakeries sales management Staff Login Model",
 *     @OA\Xml(
 *         name="StaffLoginModel"
 *     )
 * )
 */
class StaffLoginModel
{


    /**
     * @OA\Property(
     *          title="Staff Phone Number",
     *          example="08012345678"
     *      ),
     *
     * @var string
     */
    private $mobile_number;

    /**
     * @OA\Property(
     *      title="Password",
     *      example="password"
     * ),
     *
     * @var string
     *
     */
    private $password;

}
