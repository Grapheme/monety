<?php

class ProductsController extends \BaseController {
	
	protected $product;
	
	public function __construct(Product $product){
		
		$this->product = $product;
		$this->beforeFilter('catalogs');
	}
	
	
	public function getIndex(){
		
		$products = $this->product->all();
		return View::make('modules.catalogs.products.index', compact('products'));
	}

	public function getCreate(){
		
		$this->moduleActionPermission('catalogs','create');
		$catalogs = Catalog::all();
		$category_groups = CategoryGroup::all();
		if(is_null($catalogs)):
			return Redirect::to(slink::createAuthLink('catalogs/products'))
				->with('message','Для добавления продукта предварительно нужно создать каталог продуктов!<p class="margin-top-10"><a class="btn btn-primary" href="'.slink::createAuthLink('catalogs/create').'">Добавить каталог</a>
				</p>');
		endif;
		$data_fields = array();
		if($catalogs->count() == 1):
			if(!empty($catalogs->first()->fields)):
				$data_fields = json_decode($catalogs->first()->fields);
			endif;
		endif;
		return View::make('modules.catalogs.products.create',compact('catalogs','category_groups','data_fields'));
	}

	/**
	 * Store a newly created product in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Product::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Product::create($data);

		return Redirect::route('products.index');
	}

	/**
	 * Display the specified product.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$product = Product::findOrFail($id);

		return View::make('products.show', compact('product'));
	}

	/**
	 * Show the form for editing the specified product.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$product = Product::find($id);

		return View::make('products.edit', compact('product'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$product = Product::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Product::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$product->update($data);

		return Redirect::route('products.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Product::destroy($id);

		return Redirect::route('products.index');
	}

}