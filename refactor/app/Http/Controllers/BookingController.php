<?php

namespace DTApi\Http\Controllers;

use DTApi\Models\Job;
use DTApi\Http\Requests;
use DTApi\Models\Distance;
use Illuminate\Http\Request;
use DTApi\Repository\BookingRepository;

/**
 * Class BookingController
 * @package DTApi\Http\Controllers
 */
class BookingController extends Controller
{

    /**
     * @var BookingRepository
     */
    protected $repository;

    /**
     * BookingController constructor.
     * @param BookingRepository $bookingRepository
     */
    public function __construct(BookingRepository $bookingRepository)
    {
        $this->repository = $bookingRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */


    //  Refactor suggestions by Saad

    public function index(RequestValidator $request)
    {
        if ($user_id = $request->get('user_id')) {

            $response = $this->repository->getUsersJobs($user_id);
        }
        // It is always better to use config rather than direct env parameters

        elseif ($request->__authenticatedUser->user_type == config('USER.ADMIN_ROLE_ID') || $request->__authenticatedUser->user_type == config('USER.SUPERADMIN_ROLE_ID')) {
            $response = $this->repository->getAll($request);
        } else {
            $response = 'Not matched to any criteria';
        }

        return response($response);
    }

    // End Refactor suggestions   


    public function index(Request $request)
    {
        if ($user_id = $request->get('user_id')) {

            $response = $this->repository->getUsersJobs($user_id);
        } elseif ($request->__authenticatedUser->user_type == env('ADMIN_ROLE_ID') || $request->__authenticatedUser->user_type == env('SUPERADMIN_ROLE_ID')) {
            $response = $this->repository->getAll($request);
        }

        return response($response);
    }

    /**
     * @param $id
     * @return mixed
     */

    //  Refactore Code here

    public function show($id)
    {
        $job = $this->repository->with('translatorJobRel.user')->find($id);



        return response($job);
    }


    // End here

    public function show($id)
    {
        $job = $this->repository->with('translatorJobRel.user')->find($id);

        return response($job);
    }

    /**
     * @param Request $request
     * @return mixed
     */

    //  Refactor code here


    public function store(StoreRequestValidator $request)
    {

        $response = $this->repository->store($request->all());
        return response($response);
    }


    // End here


    public function store(Request $request)
    {
        $data = $request->all();

        $response = $this->repository->store($request->__authenticatedUser, $data);

        return response($response);
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */


    //  Refactore code here
    public function update($id, UpdateRequestValidator $request)
    {

        // Skinny Controller code is always better
        // Replace array_except() Function: Instead of using array_except(), consider using the Arr::except() helper function provided by Laravel. This provides a cleaner and more readable way to exclude specific elements from an array.
        $response = $this->repository->updateJob($id, Arr::except($request->all(), ['_token', 'submit']), $request->__authenticatedUser);
        return response($response);
    }

    // End refactor code here



    public function update($id, Request $request)
    {
        $data = $request->all();
        $cuser = $request->__authenticatedUser;
        $response = $this->repository->updateJob($id, array_except($data, ['_token', 'submit']), $cuser);

        return response($response);
    }

    /**
     * @param Request $request
     * @return mixed
     */

    //  Refactor here

    public function immediateJobEmail(EmailRequestValidator $request)
    {

        $response = $this->repository->storeJobEmail($request->all());
        return response($response);
    }

    // End here


    public function immediateJobEmail(Request $request)
    {
        $adminSenderEmail = config('app.adminemail');
        $data = $request->all();

        $response = $this->repository->storeJobEmail($data);

        return response($response);
    }

    /**
     * @param Request $request
     * @return mixed
     */


    //  Refactor code here

    public function getHistory(HistoryRequestValidator $request)
    {
        // Validation request will do eveything for you
        // There is no need to send a request parameter as well as Whole request parameter at the same time. Just Send request all data
        $response = $this->repository->getUsersJobsHistory($request->all());
        return response($response);
    }

    // End refactor code 

    public function getHistory(Request $request)
    {
        if ($user_id = $request->get('user_id')) {

            $response = $this->repository->getUsersJobsHistory($user_id, $request);
            return response($response);
        }

        return null;
    }

    /**
     * @param Request $request
     * @return mixed
     */


    //  Refactor code here
    public function acceptJob(RequestValidator $request)
    {
        $response = $this->repository->acceptJob($request->all());
        return response($response);
    }


    // End here


    public function acceptJob(Request $request)
    {
        $data = $request->all();
        $user = $request->__authenticatedUser;

        $response = $this->repository->acceptJob($data, $user);

        return response($response);
    }


    // Refactor code here

    public function acceptJobWithId(RequestValidator $request)
    {
        $response = $this->repository->acceptJobWithId($request->get('job_id'), $request->__authenticatedUser);
        return response($response);
    }


    // End here



    public function acceptJobWithId(Request $request)
    {
        $data = $request->get('job_id');
        $user = $request->__authenticatedUser;

        $response = $this->repository->acceptJobWithId($data, $user);

        return response($response);
    }

    /**
     * @param Request $request
     * @return mixed
     */

    //  Refactor code here

    public function cancelJob(CancelRequestValidator $request)
    {

        $response = $this->repository->cancelJobAjax($request->all());
        return response($response);
    }

    // End here


    public function cancelJob(Request $request)
    {
        $data = $request->all();
        $user = $request->__authenticatedUser;

        $response = $this->repository->cancelJobAjax($data, $user);

        return response($response);
    }

    /**
     * @param Request $request
     * @return mixed
     */

    //  Refactor code here

    public function endJob(RequestValidator $request)
    {
        $response = $this->repository->endJob($request->all());
        return response($response);
    }


    //  End here



    public function endJob(Request $request)
    {
        $data = $request->all();

        $response = $this->repository->endJob($data);

        return response($response);
    }



    // Refactor code here
    public function customerNotCall(RequestValidator $request)
    {
        $response = $this->repository->customerNotCall($request->all());
        return response($response);
    }


    // End here


    public function customerNotCall(Request $request)
    {
        $data = $request->all();
        $response = $this->repository->customerNotCall($data);
        return response($response);
    }

    /**
     * @param Request $request
     * @return mixed
     */

    //  Refactor code here

    public function getPotentialJobs(RequestVAidation $request)
    {
        $response = $this->repository->getPotentialJobs($request->__authenticatedUser);
        return response($response);
    }

    // End here


    public function getPotentialJobs(Request $request)
    {
        $data = $request->all();
        $user = $request->__authenticatedUser;

        $response = $this->repository->getPotentialJobs($user);

        return response($response);
    }


    // Refactore code here

    public function distanceFeed(DistanceRequestValidator $request)
    {
        $data = $request->all();

        $distance = isset($data['distance']) ? $data['distance'] : "";
        $time = isset($data['time']) ? $data['time'] : "";
        $jobid = isset($data['jobid']) ? $data['jobid'] : "";
        $session = isset($data['session_time']) ? $data['session_time'] : "";
        $flagged = $data['flagged'] ? "yes" : "no";
        if ($data['flagged']) {
            if (!$data['admincomment']) return "Please, add comment";
        }
        $manually_handled = $data['manually_handled'] ? "yes" : "no";
        $by_admin = $data['by_admin'] ? "yes" : "no";
        $admincomment = isset($data['admincomment']) && $data['admincomment'] ? $data['admincomment'] : "";
        if ($time || $distance) {
            Distance::where('job_id', '=', $jobid)->update(array('distance' => $distance, 'time' => $time));
        }
        if ($admincomment || $session || $flagged || $manually_handled || $by_admin) {
            Job::where('id', '=', $jobid)->update(array('admin_comments' => $admincomment, 'flagged' => $flagged, 'session_time' => $session, 'manually_handled' => $manually_handled, 'by_admin' => $by_admin));
        }
        return response('Record updated!');
    }

    // End here



    public function distanceFeed(Request $request)
    {
        $data = $request->all();

        if (isset($data['distance']) && $data['distance'] != "") {
            $distance = $data['distance'];
        } else {
            $distance = "";
        }
        if (isset($data['time']) && $data['time'] != "") {
            $time = $data['time'];
        } else {
            $time = "";
        }
        if (isset($data['jobid']) && $data['jobid'] != "") {
            $jobid = $data['jobid'];
        }

        if (isset($data['session_time']) && $data['session_time'] != "") {
            $session = $data['session_time'];
        } else {
            $session = "";
        }

        if ($data['flagged'] == 'true') {
            if ($data['admincomment'] == '') return "Please, add comment";
            $flagged = 'yes';
        } else {
            $flagged = 'no';
        }

        if ($data['manually_handled'] == 'true') {
            $manually_handled = 'yes';
        } else {
            $manually_handled = 'no';
        }

        if ($data['by_admin'] == 'true') {
            $by_admin = 'yes';
        } else {
            $by_admin = 'no';
        }

        if (isset($data['admincomment']) && $data['admincomment'] != "") {
            $admincomment = $data['admincomment'];
        } else {
            $admincomment = "";
        }
        if ($time || $distance) {

            $affectedRows = Distance::where('job_id', '=', $jobid)->update(array('distance' => $distance, 'time' => $time));
        }

        if ($admincomment || $session || $flagged || $manually_handled || $by_admin) {

            $affectedRows1 = Job::where('id', '=', $jobid)->update(array('admin_comments' => $admincomment, 'flagged' => $flagged, 'session_time' => $session, 'manually_handled' => $manually_handled, 'by_admin' => $by_admin));
        }

        return response('Record updated!');
    }


    // Refactor here
    public function reopen(RequestValidate $request)
    {
        $response = $this->repository->reopen($request->all());
        return response($response);
    }
    // End here

    public function reopen(Request $request)
    {
        $data = $request->all();
        $response = $this->repository->reopen($data);

        return response($response);
    }


    // Refactor here
    public function resendNotifications(RequestValidation $request)
    {
        $job = $this->repository->findorfail($request['jobid']);
        $job_data = $this->repository->jobToData($job);
        $this->repository->sendNotificationTranslator($job, $job_data, '*');
        return response(['success' => 'Push sent']);
    }

    // End here

    public function resendNotifications(Request $request)
    {
        $data = $request->all();
        $job = $this->repository->find($data['jobid']);
        $job_data = $this->repository->jobToData($job);
        $this->repository->sendNotificationTranslator($job, $job_data, '*');

        return response(['success' => 'Push sent']);
    }

    /**
     * Sends SMS to Translator
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */


    //  Refactor here

    public function resendSMSNotifications(RequeRequestValidationst $request)
    {
        $job = $this->repository->find($request['jobid']);
        try {
            $this->repository->sendSMSNotificationToTranslator($job);
            return response(['success' => 'SMS sent']);
        } catch (\Exception $e) {
            return response(['Error' => $e->getMessage()]);
        }
    }

    // End here

    public function resendSMSNotifications(Request $request)
    {
        $data = $request->all();
        $job = $this->repository->find($data['jobid']);
        $job_data = $this->repository->jobToData($job);

        try {
            $this->repository->sendSMSNotificationToTranslator($job);
            return response(['success' => 'SMS sent']);
        } catch (\Exception $e) {
            return response(['success' => $e->getMessage()]);
        }
    }
}
