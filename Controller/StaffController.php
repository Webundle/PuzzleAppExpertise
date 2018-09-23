<?php
namespace Puzzle\App\ExpertiseBundle\Controller;

use GuzzleHttp\Exception\BadResponseException;
use Puzzle\ConnectBundle\ApiEvents;
use Puzzle\ConnectBundle\Event\ApiResponseEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * 
 * @author AGNES Gnagne Cedric <cecenho55@gmail.com>
 *
 */
class StaffController extends Controller
{
	/***
	 * List staffs
	 * 
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function listAction(Request $request) {
		try {
		    /** @var Puzzle\ConnectBundle\Service\PuzzleAPIClient $apiClient */
		    $apiClient = $this->get('puzzle_connect.api_client');
		    $staffs = $apiClient->pull('/expertise/projects', null);
		}catch (BadResponseException $e) {
		    /** @var EventDispatcher $dispatcher */
		    $dispatcher = $this->get('event_dispatcher');
		    $dispatcher->dispatch(ApiEvents::API_BAD_RESPONSE, new ApiResponseEvent($e, $request));
		    $staffs = [];
		}
		
		return $this->render($this->getParameter('app_expertise.templates')['staff']['list'],['staffs' => $staffs]);
	}
    
    /***
     * Show staff
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request, $id) {
        try {
            /** @var Puzzle\ConnectBundle\Service\PuzzleAPIClient $apiClient */
            $apiClient = $this->get('puzzle_connect.api_client');
            $staff = $apiClient->pull('/expertise/staffs/'.$id);
        }catch (BadResponseException $e) {
            /** @var EventDispatcher $dispatcher */
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(ApiEvents::API_BAD_RESPONSE, new ApiResponseEvent($e, $request));
            $staff = [];
        }
        
        return $this->render($this->getParameter('app_expertise.templates')['staff']['show'], array(
            'staff' => $staff
        ));
    }
}
