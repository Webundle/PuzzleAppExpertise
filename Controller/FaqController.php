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
class FaqController extends Controller
{
	/***
	 * List faqs
	 * 
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function listAction(Request $request) {
        try {
    		/** @var Puzzle\ConnectBundle\Service\PuzzleAPIClient $apiClient */
    		$apiClient = $this->get('puzzle_connect.api_client');
    		$faqs = $apiClient->pull('/expertise/faqs', null);
        }catch (BadResponseException $e) {
            /** @var EventDispatcher $dispatcher */
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(ApiEvents::API_BAD_RESPONSE, new ApiResponseEvent($e, $request));
            $faqs = [];
        }
		
		return $this->render($this->getParameter('app_expertise.templates')['faq']['list'],['faqs' => $faqs]);
	}
	
    /***
     * Show faq
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request, $id) {
        try {
            /** @var Puzzle\ConnectBundle\Service\PuzzleAPIClient $apiClient */
            $apiClient = $this->get('puzzle_connect.api_client');
            $faq = $apiClient->pull('/expertise/faqs/'.$id);
            
            $parent = null;
            if (isset($faq['_embedded'])) {
                $parent = $faq['_embedded']['parent'] ?? null;
            }
        }catch (BadResponseException $e) {
            /** @var EventDispatcher $dispatcher */
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(ApiEvents::API_BAD_RESPONSE, new ApiResponseEvent($e, $request));
            $faq = $parent = [];
        }
        
        return $this->render($this->getParameter('app_expertise.templates')['faq']['show'], array(
            'faq' => $faq,
            'parent' => $parent
        ));
    }
}
