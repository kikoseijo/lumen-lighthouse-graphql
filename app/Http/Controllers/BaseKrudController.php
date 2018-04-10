<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ksoft\Klaravel\Traits\LumenResponsesTrait;
use Ksoft\Klaravel\Traits\KrudControllerTrait;

class BaseKrudController extends Controller
{
    use LumenResponsesTrait, KrudControllerTrait;

    protected $repo;
    protected $path;
    protected $createInteraction;
    protected $updateInteraction;

    public function index(Request $request)
    {
        $perPageKey = config('ksoft.CONSTANTS.take', 'PER_PAGE');
        $perPage = $request->take ?? session($perPageKey, 10);
        $records = $this->repo->withPagination($perPage, $request);

        $res = array_merge($this->loadCrudStyles(), [
            'records'=> $records,
            'model_name' => $this->path
          ]);

        return $this->returnCustomView($res);
    }

    public function create()
    {
        $res = array_merge($this->loadCrudStyles(), ['model_name' => $this->path]);

        return $this->returnCustomView($res, 'create');
    }

    public function store(Request $request)
    {
        $record = $this->interaction($this->createInteraction, [$request->all()]);
        return redirect($this->path)->with('flash_message', 'Record added succesfully');
        // return $this->createdResponse($record);
    }

    public function show($id)
    {
        // $record = $this->repo->find($id);
        return redirect($this->path);
        // return view($viewsBasePath.$this->path.'.show', [$this->singular => $record]);
    }

    public function edit($id)
    {
        $record = $this->repo->find($id);

        $res = array_merge($this->loadCrudStyles(), [
            'record' => $record,
            'model_name' => $this->path,
        ]);

        return $this->returnCustomView($res, 'edit');
    }

    public function update(Request $request, $id)
    {
        $record = $this->interaction($this->updateInteraction, [$id, $request->all()]);
        return redirect($this->path)->with('flash_message', 'Record updated succesfully');
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return redirect($this->path)->with('flash_message', 'Record deleted succesfully');
    }

    protected function loadCrudStyles()
    {
        $viewsBasePath = config('ksoft.module.crud.views_base_path', '');
        $crudWrapperClass = config('ksoft.style.crud_container_wrapper','container -body-block pb-5');
        return [
            'viewsBasePath' => $viewsBasePath,
            'crudWrapperClass' => $crudWrapperClass
        ];
    }

    protected function returnCustomView($data, $key='index')
    {
        $view = $data['viewsBasePath'] . $data['model_name'] . '.' .$key;
        if(view()->exists($view)){
            return view($view, $data);
        }
        return view('klaravel::crud.' . $key, $data);
    }

}


/**
 *  this are the params refrences to match the generated in the Controller.
 *  Adjust to your needs once generated.
 */

 /**
  * @SWG\Swagger(
  *   schemes={"http","https"},
  *   host="sunnyface.com",
  *   basePath="/v1",
  *   @SWG\Info(title="Sunnyface.com v1 API", version="1.0", description="Sunnyface.com platform API"),
  *   @SWG\SecurityScheme(
  *     securityDefinition="default",
  *     type="apiKey",
  *     in="header",
  *     name="Authorization"
  *   )
  * )
  */

 /**
  *   @SWG\Parameter(parameter="id_in_path", name="id", description="Record's ID", type="integer", required=true,in="path"),
  *   @SWG\Parameter(parameter="sort", name="sort", description="To sort desc need to put the character - before the field.", type="string", required=false, in="query"),
  *   @SWG\Parameter(parameter="columns", name="columns", description="To limit columns", type="string", required=false, in="query"),
  *   @SWG\Parameter(parameter="take", name="take", default="10", description="Number of records per page, 0 will return all records", type="integer", required=false, in="query"),
  *   @SWG\Parameter(parameter="page", name="page", default="1", description="Page number to show.", type="integer", required=false, in="query"),
 */


/**
 *   @SWG\Response(
 *      response="ValidationResponse",
 *      description="Validation errors",
 *      @SWG\Schema(
 *        @SWG\Property(property="success", type="boolean", default=false),
 *        @SWG\Property(property="errors", ref="#/definitions/ValidationError"),
 *        @SWG\Property(property="status_code", type="integer", format="int32", example=422)
 *        )
 *    )
 */

/**
 *   @SWG\Response(
 *      response="PaginationResponse",
 *      description="Validation errors",
 *      @SWG\Schema(
 *          @SWG\Property(property="current_page", type="integer", format="int32"),
 *          @SWG\Property(property="data"),
 *          @SWG\Property(property="first_page_url", type="string"),
 *          @SWG\Property(property="from", type="integer", format="int32"),
 *          @SWG\Property(property="last_page", type="integer", format="int32"),
 *          @SWG\Property(property="last_page_url", type="string"),
 *          @SWG\Property(property="next_page_url", type="string"),
 *          @SWG\Property(property="path", type="string"),
 *          @SWG\Property(property="per_page", type="string"),
 *          @SWG\Property(property="prev_page_url", type="string"),
 *          @SWG\Property(property="to", type="integer", format="int32"),
 *          @SWG\Property(property="total", type="integer", format="int32"),
 *        )
 *    )
 */

 /**
  * @SWG\Response(
  *      response="JsonResponse",
  *      description="Default response",
  *      @SWG\Schema(
  *        @SWG\Property(property="success", type="boolean", default=true),
  *        @SWG\Property(property="data"),
  *        @SWG\Property(property="status_code", type="integer", format="int32", example=200)
  *      )
  * )
 */



 /**
  *  @SWG\Definition(definition="Timestamps",
  *    @SWG\Property(property="created_at", type="string", format="date-time",
  *      description="Creation date", example="2018-08-08 00:00:00"
  *    ),
  *    @SWG\Property(property="updated_at", type="string", format="date-time",
  *      description="Last updated", example="2018-08-08 00:00:00"
  *    )
  *  ),
  *  @SWG\Definition(definition="ValidationError",
  *      @SWG\Property(property="field_name", type="array", @SWG\Items(type="string", example="This field its required"))
  *  ),
  *  @SWG\Definition(definition="record_id",
  *    @SWG\Property(property="id", type="integer", format="int32")
  *  ),
  *  @SWG\Definition(definition="slug",
  *    @SWG\Property(property="slug", type="string")
  *  )
  */
