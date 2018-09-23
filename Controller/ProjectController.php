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
class ProjectController extends Controller
{
	/***
	 * List projects
	 * 
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function listAction(Request $request){
		try {
    		/** @var Puzzle\ConnectBundle\Service\PuzzleAPIClient $apiClient */
    		$apiClient = $this->get('puzzle_connect.api_client');
    		$projects = $apiClient->pull('/expertise/projects', null);
        }catch (BadResponseException $e) {
            /** @var EventDispatcher $dispatcher */
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(ApiEvents::API_BAD_RESPONSE, new ApiResponseEvent($e, $request));
            $projects = [];
        }
		
        return $this->render($this->getParameter('app_expertise.templates')['project']['list'],['projects' => $projects]);
	}
    
    /***
     * Show project
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request, $id) {
        try {
            /** @var Puzzle\ConnectBundle\Service\PuzzleAPIClient $apiClient */
            $apiClient = $this->get('puzzle_connect.api_client');
            $project = $apiClient->pull('/expertise/projects/'.$id);
        }catch (BadResponseException $e) {
            /** @var EventDispatcher $dispatcher */
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(ApiEvents::API_BAD_RESPONSE, new ApiResponseEvent($e, $request));
            $project = [];
        }
        
        return $this->render($this->getParameter('app_expertise.templates')['project']['show'], array(
            'project' => $project
        ));
    }
}
