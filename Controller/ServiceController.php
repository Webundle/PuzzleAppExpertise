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
class ServiceController extends Controller
{
	/***
	 * List services
	 * 
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function listAction(Request $request, $current = "NULL") {
        try {
            $criteria = [];
            $criteria['filter'] = 'parent=='.$current;
            
            /** @var Puzzle\ConnectBundle\Service\PuzzleAPIClient $apiClient */
            $apiClient = $this->get('puzzle_connect.api_client');
            
            $services = $apiClient->pull('/expertise/services', $criteria);
            $currentService = $current != "NULL" ? $apiClient->pull('/expertise/services/'.$current) : null;
            
            if ($currentService && isset($currentService['_embedded']) && isset($currentService['_embedded']['parent'])) {
                $parent = $currentService['_embedded']['parent'];
            }else {
                $parent = null;
            }
        }catch (BadResponseException $e) {
            /** @var EventDispatcher $dispatcher */
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(ApiEvents::API_BAD_RESPONSE, new ApiResponseEvent($e, $request));
            $services = $parent = $currentService = [];
        }
		
        return $this->render($this->getParameter('app_expertise.templates')['service']['list'],[
		    'services'      => $services,
		    'currentService' => $currentService,
		    'parent'          => $parent
		]);
	}
	
    /***
     * Show service
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request, $id) {
        try {
            /** @var Puzzle\ConnectBundle\Service\PuzzleAPIClient $apiClient */
            $apiClient = $this->get('puzzle_connect.api_client');
            $service = $apiClient->pull('/expertise/services/'.$id);
            $childs = $apiClient->pull('/expertise/services/'.['filter' => 'parent=='. $id]);
            
            $parent = null;
            if (isset($service['_embedded'])) {
                $parent = $service['_embedded']['parent'] ?? null;
            }
        }catch (BadResponseException $e) {
            /** @var EventDispatcher $dispatcher */
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(ApiEvents::API_BAD_RESPONSE, new ApiResponseEvent($e, $request));
            $service = $parent = $childs = [];
        }
        
        return $this->render($this->getParameter('app_expertise.templates')['service']['show'], array(
            'service' => $service,
            'parent' => $parent,
            'childs' => $childs
        ));
    }
}
