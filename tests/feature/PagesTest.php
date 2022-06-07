<?php

use App\Models\MaterialModel;
use App\Models\MethodModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class PagesTest extends ProjectTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrateOnce = true;
    protected $seedOnce    = true;

    public function testRootShowsHomePage()
    {
        $result = $this->get('/');

        $result->assertStatus(200);
        $result->assertSee('How it Works', 'h3');
    }

    public function testAboutOptions()
    {
        // Create two Methods, with and without Material
        $method1  = fake(MethodModel::class);
        $method2  = fake(MethodModel::class);
        $material = fake(MaterialModel::class, ['method_id' => $method2->id]);

        $result = $this->get('about/options');

        $result->assertStatus(200);
        $result->assertSee('Services and Pricing', 'h3');

        // Check for each Methods and Material
        $result->assertSee($method1->name, 'h4');
        $result->assertSee($method2->name, 'h4');
        $result->assertSee($material->name, 'strong');
        $result->assertSee('This print method has no available materials.', 'em');
    }

    public function testAboutTerms()
    {
        $result = $this->get('about/terms');

        $result->assertStatus(200);
        $result->assertSee('Contract of agreement', 'h3');
    }

    public function testAboutPrivacy()
    {
        $result = $this->get('about/privacy');

        $result->assertStatus(200);
        $result->assertSee('Sensitive jobs', 'h3');
    }

    public function testPageNotFound()
    {
        $this->expectException(PageNotFoundException::class);

        $this->get('about/bananas');
    }
}
