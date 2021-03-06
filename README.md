# RestClientBundle

Symfony **Rest Client Bundle** using [GuzzleHttp](http://docs.guzzlephp.org/en/latest/index.html) and [Ocramius/ProxyManager](http://ocramius.github.io/ProxyManager/)


Installation
============

To install CosRestClientBundle with Composer execute the following command:

    $ composer require "cos/rest-client-bundle": "dev-master"
    
Now, Composer will automatically download all required files, and install them
for you. All that is left to do is to update your ``AppKernel.php`` file, and
register the new bundle:

    <?php

    // in AppKernel::registerBundles()
    $bundles = array(
        // ...
        new Cos\RestClientBundle\CosRestClientBundle(),
        // ...
    );

The bundle is now installed. Lets start configure with the bundle.

Configuration reference
=========

    # config.yml
    cos_rest_client:
        annotation_reader: annotation_reader # annotation reader service id
        # http clients and base URLs
        clients:
            default: { baseUri: 'https://jsonplaceholder.typicode.com' }




Usage
======

Define a rest resource interface
-------
    <?php
    
    namespace AppBundle\Rest;
    
    
    use Cos\RestClientBundle\Annotation\Client;
    use Cos\RestClientBundle\Annotation\Endpoint;
    use Cos\RestClientBundle\Annotation\Form;
    use Cos\RestClientBundle\Annotation\Json;
    use Cos\RestClientBundle\Annotation\Path;
    use Cos\RestClientBundle\Annotation\Query;
    
    /**
     * Client configuration  
     * @Client(name="default")
     */
    interface Posts
    {
        /**
         * @Path(name="id", paramName="idParam")
         * @Endpoint(uri="/posts/{id}", method="get")
         */
        public function get($idParam);
    
        /**
         * @Query(name="userId")
         * @Endpoint(uri="/posts")
         */
        public function getWithQuery($userId);
    
        /**
         * @Form(name="formData")
         * @Endpoint(uri="/posts", method="POST")
         */
        public function form(array $formData);
    
        /**
         * @Json(name="data")
         * @Endpoint(uri="/posts", method="POST")
         */
        public function json(array $data);
    }
    
Create proxy for Posts
------

    <?php
        //in controller
        $proxyFactory = $this->get('cos_rest_client.proxy_factory');
        $proxy = $proxyFactory->create(Posts::class);


Call proxy methods defined in interface
-----

    <?php
        $proxy->get(1); //request for client base uri + /posts/1
        $proxy->getWithQuery(1)->getBody()->getContents(); //request for /posts?userId=1
        $data = ['foo' => 'bar']
        $proxy->form($data) //post request where $data is sent as application/x-www-form-urlencoded
        $proxy->json($data) // send data as json

Response
-----
Every method call from a proxy return a [Psr\Http\Message\ResponseInterface](http://docs.guzzlephp.org/en/latest/quickstart.html#using-responses)

Full example
--------
https://github.com/cosminseceleanu/RestClientBundleSample

Events
=======

**RequestEvent**: dispatched before a request is executed<br>
**ResponseEvent**: dispatched when response is received



            

            

