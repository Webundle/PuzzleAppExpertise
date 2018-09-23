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
class TestimonialController extends Controller
{
	/***
	 * List testimonials
	 * 
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function listAction(Request $request) {
        try {
    		/** @var Puzzle\ConnectBundle\Service\PuzzleAPIClient $apiClient */
    		$apiClient = $this->get('puzzle_connect.api_client');
    		$testimonials = $apiClient->pull('/expertise/testimonials', null);
        }catch (BadResponseException $e) {
            /** @var EventDispatcher $dispatcher */
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(ApiEvents::API_BAD_RESPONSE, new ApiResponseEvent($e, $request));
            $testimonials = [];
        }
		
        return $this->render($this->getParameter('app_expertise.templates')['testimonial']['list'],['testimonials' => $testimonials]);
	}
	
    /***
     * Show testimonial
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request, $id) {
        try {
            /** @var Puzzle\ConnectBundle\Service\PuzzleAPIClient $apiClient */
            $apiClient = $this->get('puzzle_connect.api_client');
            $testimonial = $apiClient->pull('/expertise/testimonials/'.$id);
        }catch (BadResponseException $e) {
            /** @var EventDispatcher $dispatcher */
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(ApiEvents::API_BAD_RESPONSE, new ApiResponseEvent($e, $request));
            $testimonial = [];
        }
        
        return $this->render($this->getParameter('app_expertise.templates')['testimonial']['show'], array(
            'testimonial' => $testimonial
        ));
    }
}
