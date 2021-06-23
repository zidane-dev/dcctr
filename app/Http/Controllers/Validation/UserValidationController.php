<?php

namespace App\Http\Controllers\Validation;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserHelperController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class UserValidationController extends Controller
{
    public function get_validation_states(){
        $userRole = (new UserHelperController)->getUserRole();
        switch ($userRole) {
            case 's-a':         echo ('Task unavailable');      break; //THROW OR LEAVE OPEN
            case 'apf':          
            case 'pf':          $newState = 1;                  break; // pf
            case 'acs':           
            case 'cs':          $newState = 2;                  break; 
            case 'd-p':         $newState = 3;                  break; // sd p
            case 'ad':                                                 // ac d
            case 'd-r':         $newState = 4;                  break; // sd r
            case 'dcs':         $newState = 5;                  break; // dc cs
            case 'dcd':         $newState = 6;                  break; // dc cd
            case 'dd':          $newState = 7;                  break; // DOESNT HAVE VALIDATE PERM
            
            default:            throw new Exception("Error Fetching the Update State @UserValidationController", 1);                           // fix THROW        
        }
        return $newState;
    }
    public function get_supposed_states($userRole = null){
        if($userRole == null)
            $userRole = (new UserHelperController)->getUserRole();

        switch ($userRole) {
            case 's-a':    $supposedState = [0,1,2,3,4,5,6,7];  break; //THROW OR LEAVE OPEN
            
            case 'apf': 
            case 'pf':          $supposedState = [0];           break;
            
            case 'acs':         $supposedState = [1];           break;
            case 'cs':          $supposedState = [0, 1];        break;
            
            case 'ad':    
            case 'd-p':         $supposedState = [2];           break;
                      
            case 'd-r':         $supposedState = [3];           break;
            
            case 'dcs':         $supposedState = [4];           break;
            case 'dcd':         $supposedState = [5];           break;
            case 'dd':          $supposedState = [6];           break;
            case 'public':      $supposedState = [7];           break;
            
            default:            throw new Exception("Error Fetching the current States @UserValidationController", 1);                             //fix the def THROOOW
        }
        return $supposedState;
    }

    public function get_reject_states($userRole = null){
        if($userRole == null)
            $userRole = (new UserHelperController)->getUserRole();

        switch ($userRole) {
            case 's-a':
            case 'apf':
            case 'pf':          
            case 'cs':          $rejectState = [0,1];         break;
            
            default:            $rejectState = [0]; 
        }
        return $rejectState;
    }
}
