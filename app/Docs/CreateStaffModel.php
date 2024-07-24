<?php

/**
 * Created By: Ide Peter
 * PC: Petide Systems
 * Project: Peres Bakeries Limited
 * Class Name: CreateStaffModel.php
 * Date Created: 07/19/2024
 * Time Created: 10:12 AM
 */

 namespace App\Docs;

 /**
 *
 * @package Peresbakeries_api
 * @author  Peter Ide <petideenterprise@gmail.com>
 *
 * @OA\Schema(
 *     title="CreateStaffModel",
 *     description="Pares Bakeries Limited Login Model",
 *     @OA\Xml(
 *         name="CreateStaffModel"
 *     )
 * )
 */

 class CreateStaffModel
 {
    /**
     * @OA\Property(
     *          title="Staff Surname",
     *          example="Ide"
     *      ),
     *
     * @var string
     */
    private $surname;

    /**
     * @OA\Property(
     *          title="Staff First Name",
     *          example="Peter"
     *      ),
     *
     * @var string
     */
    private $firstname;

    // /**
    //  * @OA\Property(
    //  *          title="Parent Other Name",
    //  *          example="Obu"
    //  *      ),
    //  *
    //  * @var string
    //  */
    // private $othername;

    // /**
    //  * @OA\Property(
    //  *          title="Parent Email",
    //  *          example="me@example.com"
    //  *      ),
    //  *
    //  * @var string
    //  */
    // private $email;

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
     *          title="Staff Address",
     *          example="No. 8 Yabrifa Close, Kpansia, Yenagoa"
     *      ),
     *
     * @var string
     */
    private $address;

    /**
     * @OA\Property(
     *          title="Staff position",
     *          example="HR"
     *      ),
     *
     * @var string
     */
    private $position;

    // /**
    //  * @OA\Property(
    //  *          title="Parent LGA of origin",
    //  *          example="Yenagoa"
    //  *      ),
    //  *
    //  * @var string
    //  */
    // private $lga;

    /**
     * @OA\Property(
     *          title="Staff Gender",
     *          example="Male, Female"
     *      ),
     *
     * @var string
     */
    private $gender;

    /**
     * @OA\Property(
     *          title="Staff Date of Birth",
     *          example="dd-mm-yyyy, mm-dd-yyyy, yyyy-mm-dd, dd/mm/yyyy, mm/dd/yyyy, yyyy/mm/dd"
     *      ),
     *
     * @var string
     */
    private $dob;

    // /**
    //  * @OA\Property(
    //  *      title="Parent Profile Photo",
    //  *      example="image file"
    //  * ),
    //  *
    //  * @var string
    //  *
    //  */
    // private $profile_photo; 

}