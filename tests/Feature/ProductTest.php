<?php

namespace Tests\Feature;

use App\Http\Traits\StringFunctionsTrait;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    use StringFunctionsTrait;

    /** @test */
    public function get_all_products()
    {
        $this->withoutExceptionHandling();

        $this->seed();

        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/products');
        $response->assertOk();
        $this->assertCount(Product::count(), $response->json('data'));
        $response->assertJsonStructure([
            'data'=> [
                [
                    'id',
                    'productName',
                    'vendorName',
                    'price',
                    'totalSelling',
                    'votes',
                    'createdAt'
                ]
            ]
            ]);
    }

    /** @test */
    public function a_products_list_filtered_by_product_name()
    {
        $this->withoutExceptionHandling();
        $this->seed();

        $randomString = $this->RandomString(3);
        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/products?product_name='. $randomString);

        $response->assertOk();

        foreach ($response->json('data') as $item)
            self::assertStringContainsString(strtolower($randomString), strtolower($item['productName']));
    }

    /** @test */
    public function a_products_list_filtered_by_vendor_name()
    {
        $this->withoutExceptionHandling();
        $this->seed();

        $randomString = $this->RandomString(3);
        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/products?vendor_name=' . $randomString);

        $response->assertOk();

        foreach ($response->json('data') as $item)
            self::assertStringContainsString(strtolower($randomString), strtolower($item['vendorName']));
    }

    /** @test */
    public function a_products_list_filtered_by_min_price()
    {
        $this->withoutExceptionHandling();
        $this->seed();

        $randomNumber = rand(Product::max('price'), Product::min('price'));
        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/products?min_price=' . $randomNumber);

        $response->assertOk();

        foreach ($response->json('data') as $item)
            self::assertGreaterThanOrEqual($randomNumber, $item['price']);
    }

    /** @test */
    public function a_products_list_filtered_by_max_price()
    {
        $this->withoutExceptionHandling();
        $this->seed();

        $randomNumber = rand(Product::max('price'), Product::min('price'));
        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/products?max_price=' . $randomNumber);

        $response->assertOk();

        foreach ($response->json('data') as $item)
            self::assertLessThanOrEqual($randomNumber, $item['price']);
    }

    /** @test */
    public function sort_products_by_price_in_asc_order()
    {
        $this->seed();
        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/products?sort_by=price');

        $response->assertOk();

        $oldPrice = 0;
        foreach ($response->json('data') as $item)
        {
            self::assertGreaterThanOrEqual($oldPrice, $item['price']);
            $oldPrice = $item['price'];
        }
    }

    /** @test */
    public function sort_products_by_selling_in_desc_order()
    {
        $this->seed();
        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/products?sort_by=selling');

        $response->assertOk();

        $oldSelling = PHP_INT_MAX;
        foreach ($response->json('data') as $item)
        {
            self::assertLessThanOrEqual($oldSelling, $item['totalSelling']);
            $oldSelling = $item['totalSelling'];
        }
    }

    /** @test */
    public function sort_products_by_votes_in_desc_order()
    {
        $this->seed();
        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/products?sort_by=votes');

        $response->assertOk();
        $oldVotes = PHP_INT_MAX;
        foreach ($response->json('data') as $item)
        {
            self::assertLessThanOrEqual($oldVotes, $item['votes']);
            $oldVotes = $item['votes'];
        }
    }

    /** @test */
    public function a_products_list_filtered_by_multiple_search_in_specific_order()
    {
        $this->withoutExceptionHandling();

        $this->seed();

        $randomProductString = $this->RandomString(1);
        $randomVendorString = $this->RandomString(1);
        $randomMinNumber = rand(Product::max('price'), Product::min('price'));
        $randomMaxNumber = rand(Product::max('price'), $randomMinNumber);

        $sortByAttributes = ['price', 'selling', 'votes'];
        $sortByValue = $sortByAttributes[array_rand($sortByAttributes)];

        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/products?product_name=' . $randomProductString . '&vendor_name=' . $randomVendorString
                . '&min_price='. $randomMinNumber. '&max_price='. $randomMaxNumber . '&sort_by=' . $sortByValue);

        $response->assertOk();
        $oldMinNo = 0;
        $oldMaxNo = PHP_INT_MAX;

        foreach ($response->json('data') as $item)
        {
            self::assertStringContainsString(strtolower($randomProductString), strtolower($item['productName']));
            self::assertStringContainsString(strtolower($randomVendorString), strtolower($item['vendorName']));
            self::assertGreaterThanOrEqual($randomMinNumber, $item['price']);
            self::assertLessThanOrEqual($randomMaxNumber, $item['price']);
            if ($sortByValue == 'price')
            {
                self::assertGreaterThanOrEqual($oldMinNo, $item['price']);
                $oldMinNo = $item['price'];
            }
            elseif ($sortByValue == 'selling')
            {
                self::assertLessThanOrEqual($oldMaxNo, $item['totalSelling']);
                $oldMaxNo = $item['totalSelling'];
            }
            elseif ($sortByValue == 'votes')
            {
                self::assertLessThanOrEqual($oldMaxNo, $item['votes']);
                $oldMaxNo = $item['votes'];
            }

        }

    }

}
