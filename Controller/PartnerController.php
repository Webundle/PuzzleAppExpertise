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
class PartnerController extends Controller
{
	/***
	 * List partners
	 * 
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function listAction(Request $request) {
		try {
    		/** @var Puzzle\ConnectBundle\Service\PuzzleAPIClient $apiClient */
    		$apiClient = $this->get('puzzle_connect.api_client');
    		$partners = $apiClient->pull('/expertise/partners', null);
        }catch (BadResponseException $e) {
            /** @var EventDispatcher $dispatcher */
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(ApiEvents::API_BAD_RESPONSE, new ApiResponseEvent($e, $request));
            $partners = [];
        }
		
        return $this->render($this->getParameter('app_expertise.templates')['partner']['list'],['partners' => $partners]);
	}
}
