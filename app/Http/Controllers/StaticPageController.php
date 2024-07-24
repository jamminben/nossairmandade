<?php
namespace App\Http\Controllers;

use App\Enums\Languages;
use App\Models\Book;
use App\Models\Carousel;
use App\Models\LinkSection;
use App\Models\MusicianMediaFile;
use App\Models\MusicianResource;
use App\Services\GlobalFunctions;
use App\Services\LinkService;
use App\Services\ContactService;
use App\Services\PatreonService;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Spatie\Permission\Models\Role;
use App\Models\User;

class StaticPageController extends Controller
{
    private $contactService;
    private $linkService;
    private $vocabularyService;

    public function __construct(ContactService $contactService, LinkService $linkService)
    {
        $this->contactService = $contactService;
        $this->linkService = $linkService;
    }

    public function index()
    {
        $carousels = Carousel::where('is_active', 1)->orderBy('list_order')->get();
        return view('home', [ 'carousels' => $carousels ]);
    }

    public function about()
    {
        return view('about');
    }

    public function whatsNew()
    {
        return view('whats_new');
    }

    public function contact()
    {
        return view('contact');
    }

    public function handleContact(Request $request)
    {
        try {
            $this->validate($request,
                [
                    'name' => 'required|string',
                    'email' => 'required|email',
                    'subject' => 'required|string',
                    'message' => 'required|string',
                    'g-recaptcha-response' => 'required|recaptcha'
                ]
            );
        } catch (\Exception $ex) {
            die($ex->getMessage());
        }

        $this->contactService->handleContact(
            $request->get('name'),
            $request->get('email'),
            $request->get('subject'),
            $request->get('message')
        );

        return back()->with('success', __('contact.message_received'));
    }

    public function books()
    {
        $books = Book::where('display', 1)->orderBy('list_order')->get();

        return view('books', [ 'books' => $books ]);
    }
/*
    public function vocabulary($letter = null)
    {
        return view('vocabulary');
    }
*/
    public function pronunciation()
    {
        return view('pronunciation');
    }

    public function musicians()
    {
        $files = MusicianMediaFile::with('mediaFile')->get();

        return view('musicians', [ 'files' => $files ]);
    }

    public function friends()
    {
        $sections = LinkSection::orderBy('list_order')->get();

        return view('friends', [ 'sections' => $sections ]);
    }

    public function donate()
    {
        return view('donate');
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function tos()
    {
        return view('tos');
    }

    public function language($languageCode)
    {
        switch($languageCode) {
            case 'PT':
                GlobalFunctions::setCurrentLanguage(Languages::PORTUGUESE);
                break;
            case 'DG':
                GlobalFunctions::setCurrentLanguage(Languages::DINGUS);
                break;
            case 'EN':
            default:
                GlobalFunctions::setCurrentLanguage(Languages::ENGLISH);
                break;
        }

        return back();
    }

    public function registerComplete()
    {
        return view('auth.register_complete');
    }

    public function faq()
    {
        return view('faq');
    }

    public function forBeginners()
    {
        return view('for_beginners');
    }

    public function normsAndRituals()
    {
        return view ('norms_and_rituals');
    }
}
