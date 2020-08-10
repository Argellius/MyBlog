<?php
namespace App\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword {

/**
 * @SecurityAssert\UserPassword(
 *     message = "Špatně zadané heslo"
 * )
 */
protected $OldPassword;

/**
 * @Assert\Length(
 *     min = 6,
 *     minMessage = "Minimálně 6 znaků"
 * )
 */
protected $NewPassword;


public function getOldPassword() {
    return $this->OldPassword;
}

public function setOldPassword($oldPassword) {
    $this->OldPassword = $oldPassword;
    return $this;
}

   /**
     * @return string
     */
public function getNewPassword() {
    return $this->NewPassword;
}

public function setNewPassword($password) {
    $this->NewPassword = $password;
    return $this;
}

}