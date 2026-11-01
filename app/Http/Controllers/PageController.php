<?php

namespace App\Http\Controllers;

use App\Models\ContactEnquiry;
use App\Models\NewsletterSubscription;
use App\Models\SiteContent;
use App\Models\Yacht;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    private const CHARTER_DESTINATIONS = [
        'Mediterranean',
        'Caribbean & Bahamas',
        'Flexible',
    ];

    private const CHARTER_BUDGETS = [
        'Up to $75,000',
        'Up to $150,000',
        'Up to $250,000',
        'Flexible',
    ];

    private const ENQUIRY_SERVICES = [
        'charter' => 'Charter a yacht',
        'buy' => 'Buy a yacht',
        'build' => 'Build a yacht',
        'design' => 'Design or refit',
        'sell' => 'Sell a yacht',
        'management' => 'Yacht management',
        'crew' => 'Crew services',
        'general' => 'Something else',
    ];

    private const EXPERIENCE_PAGES = [
        'buy' => [
            'service' => 'buy',
            'eyebrow' => 'YACHT ACQUISITION',
            'headline' => 'FIND YOUR NEXT YACHT.',
            'description' => 'Build a shortlist around how you want to use your yacht, then move toward a considered purchase with the right professional checks.',
            'image' => 'yacht-1.jpg',
            'story_image' => 'yacht-2.jpg',
            'story_label' => 'YOUR BUYER’S BRIEF',
            'story_title' => 'A purchase built around your life at sea.',
            'story_description' => 'The best search starts with the way you plan to use the yacht. We help shape the brief, compare suitable opportunities and coordinate the next steps with your chosen legal and technical advisers. We do not publish live inventory on this page; ask us for current opportunities.',
            'process_title' => 'A clearer route from brief to handover.',
            'steps' => [
                ['title' => 'Define your brief', 'body' => 'Set out intended use, cruising area, guest capacity, preferred yacht type and a realistic total ownership budget.'],
                ['title' => 'Build a shortlist', 'body' => 'Compare suitable opportunities by condition, layout, range, operating profile and asking terms—not photography alone.'],
                ['title' => 'Verify before you commit', 'body' => 'Arrange viewings and independent survey, and have qualified legal and technical advisers review the vessel and transaction.'],
                ['title' => 'Negotiate and complete', 'body' => 'Coordinate offers, contract milestones, closing requirements and handover with your professional advisers.'],
            ],
            'brief_title' => 'What to bring to a first conversation',
            'brief_intro' => 'You do not need every answer. A few priorities make the search more focused.',
            'brief_image' => 'yacht-6.jpg',
            'brief_items' => [
                'How you expect to use the yacht: private cruising, entertaining, long-range passages or a mix.',
                'Where and when you would most like to cruise, and how many guests you typically host.',
                'Your preferred motor or sailing style, approximate size and any must-have onboard spaces.',
                'A purchase range plus an allowance for survey, refit, crew, berthing, insurance and ongoing operation.',
            ],
            'planning_image' => 'buy-planning.jpg',
            'planning_image_alt' => 'Yacht under way on open water during a buyer’s sea trial',
            'planning_title' => 'Look beyond the asking price.',
            'planning_intro' => 'A yacht can look right on paper and still be the wrong fit. Give the practical checks the same attention as the first impression.',
            'planning_items' => [
                ['title' => 'Condition and history', 'body' => 'Review maintenance records and arrange an independent survey, sea trial and specialist inspections suited to the vessel.'],
                ['title' => 'Transaction and title', 'body' => 'Ask qualified advisers to check ownership, registration, tax status, contracts and closing requirements in the relevant jurisdictions.'],
                ['title' => 'Life after handover', 'body' => 'Map crew, insurance, berthing, maintenance, fuel and refit costs into a realistic annual ownership plan.'],
            ],
            'highlights' => [
                ['title' => 'A useful shortlist', 'body' => 'Compare layout, condition, range, age and intended use against your brief before arranging viewings.', 'image' => 'yacht-3.jpg'],
                ['title' => 'Independent due diligence', 'body' => 'Plan for an independent marine survey and appropriate legal, registration and technical advice before a purchase.', 'image' => 'yacht-4.jpg'],
                ['title' => 'Total ownership picture', 'body' => 'Look beyond the asking price: discuss refit priorities, crew, operating costs and where the yacht will be based.', 'image' => 'yacht-5.jpg'],
            ],
        ],
        'build' => [
            'service' => 'build',
            'eyebrow' => 'NEW BUILD PROJECTS',
            'headline' => 'A NEW YACHT, MADE FOR YOU.',
            'description' => 'Turn an idea into a buildable brief. Align your priorities, design team and shipyard before committing to a major project.',
            'image' => 'charter-hero.jpg',
            'story_image' => 'intro-1.jpg',
            'story_label' => 'FROM FIRST SKETCH TO SEA TRIAL',
            'story_title' => 'Make the important decisions in the right order.',
            'story_description' => 'A new build is a sequence of connected choices: how you will use the yacht, what the design must deliver, which shipyard can execute it, and how scope, cost and changes will be managed. Start with a clear brief and independent professional advice before contracts are signed.',
            'process_title' => 'The decisions that shape a new build.',
            'steps' => [
                ['title' => 'Set the mission', 'body' => 'Define cruising range, guest and crew needs, operating model, key spaces and a realistic investment envelope.'],
                ['title' => 'Test feasibility', 'body' => 'Compare size, propulsion, technical requirements, design ambition and likely operating needs before choosing a direction.'],
                ['title' => 'Select the team', 'body' => 'Assess shipyard capability, design partners, capacity, references and contractual responsibilities with independent advice.'],
                ['title' => 'Manage the build', 'body' => 'Establish a clear specification, decision process, change control, milestone reporting and commissioning plan.'],
            ],
            'brief_title' => 'Prepare a useful build brief',
            'brief_intro' => 'Bring inspiration, but also the practical limits the project must respect.',
            'brief_image' => 'yacht-3.jpg',
            'brief_items' => [
                'Where you intend to cruise, how far you want to travel and the seasons you expect to use the yacht.',
                'Who will be aboard, how you entertain and which guest, crew, storage or accessibility needs matter.',
                'Your preferred size, propulsion, speed, range and any existing yacht or design references.',
                'A target investment range, funding approach, decision-makers and any timing constraints.',
            ],
            'planning_image' => 'build-planning.jpg',
            'planning_image_alt' => 'Yacht taking shape in a shipyard during a new-build project',
            'planning_title' => 'Keep the project buildable.',
            'planning_intro' => 'A strong concept needs a clear route to delivery. Test the assumptions early, while the specification and project team can still adapt.',
            'planning_items' => [
                ['title' => 'A specification with priorities', 'body' => 'Separate essential requirements from optional ideas, and agree how design decisions and changes will be documented.'],
                ['title' => 'A shipyard that fits', 'body' => 'Assess relevant experience, current capacity, subcontractors, quality processes and the team who will lead the build.'],
                ['title' => 'A plan for delivery', 'body' => 'Have independent professionals review contract milestones, payment protections, commissioning, sea trials and handover.'],
            ],
            'highlights' => [
                ['title' => 'Concept and feasibility', 'body' => 'Translate how you travel into a brief that can be tested against size, range, operating profile and investment.', 'image' => 'yacht-2.jpg'],
                ['title' => 'Shipyard and team selection', 'body' => 'Compare relevant experience, build capacity, technical fit and responsibilities—not just a headline estimate.', 'image' => 'yacht-4.jpg'],
                ['title' => 'Specification and oversight', 'body' => 'Keep requirements, approvals, changes, milestone decisions and commissioning visible throughout the project.', 'image' => 'intro-2.jpg'],
            ],
        ],
        'design' => [
            'service' => 'design',
            'eyebrow' => 'YACHT DESIGN & REFIT',
            'headline' => 'SPACES MADE FOR LIFE AT SEA.',
            'description' => 'Plan a yacht interior, refit or refresh around the way you live on board—with clear priorities for design, technical scope and delivery.',
            'image' => 'yacht-2.jpg',
            'story_image' => 'intro-1.jpg',
            'story_label' => 'DESIGN THAT WORKS ON BOARD',
            'story_title' => 'Beautiful is only the beginning.',
            'story_description' => 'A successful yacht project balances atmosphere with everyday use: movement through the space, storage, light, materials, maintenance and the realities of working at sea. Whether you are planning an interior refresh or a larger refit, establish the scope and technical constraints before selecting finishes.',
            'process_title' => 'From first walkthrough to finished spaces.',
            'steps' => [
                ['title' => 'Walk through the yacht', 'body' => 'Document what works, what does not, the condition of affected spaces and any operational constraints.'],
                ['title' => 'Set the scope', 'body' => 'Separate design aspirations from essential repairs, systems work and items that need specialist assessment.'],
                ['title' => 'Develop the design', 'body' => 'Coordinate layout, materials, lighting, storage and durability with the relevant naval, engineering and yard teams.'],
                ['title' => 'Plan delivery', 'body' => 'Agree specifications, approvals, procurement, access, sequencing and decision ownership before work begins.'],
            ],
            'brief_title' => 'Before planning a refit or redesign',
            'brief_intro' => 'A few references and clear constraints help turn ideas into a workable scope.',
            'brief_image' => 'design-brief.jpg',
            'brief_items' => [
                'Which areas you want to change and how you want those spaces to function differently.',
                'Photos, sketches or material references that show the atmosphere and details you respond to.',
                'The yacht’s location, intended work window and any access, class or operational requirements.',
                'Known maintenance issues, recent surveys or technical reports, plus a working budget range.',
            ],
            'planning_image' => 'design-planning.jpg',
            'planning_image_alt' => 'Thoughtfully detailed yacht interior with natural materials',
            'planning_title' => 'Balance beauty with life on board.',
            'planning_intro' => 'The best-looking idea is only successful if it works at sea. Bring technical, operational and maintenance needs into the design conversation early.',
            'planning_items' => [
                ['title' => 'Space and movement', 'body' => 'Test circulation, sightlines, storage and privacy for the people who will use and maintain each space.'],
                ['title' => 'Materials that belong at sea', 'body' => 'Compare weight, durability, fire performance, cleaning and replacement lead times alongside colour and texture.'],
                ['title' => 'Scope, access and sequence', 'body' => 'Coordinate the design with systems, yard access, procurement and the work window before fixing the delivery plan.'],
            ],
            'highlights' => [
                ['title' => 'Interior and layout', 'body' => 'Rethink circulation, storage, lighting, finishes and the way guest and crew spaces support life aboard.', 'image' => 'yacht-3.jpg'],
                ['title' => 'Refit scope', 'body' => 'Bring design choices together with maintenance, technical work, access and the time available in the yard.', 'image' => 'yacht-5.jpg'],
                ['title' => 'Materials for marine use', 'body' => 'Consider durability, weight, care, safety and lead times alongside appearance when comparing materials.', 'image' => 'island.jpg'],
            ],
        ],
        'destinations' => [
            'eyebrow' => 'CHARTER DESTINATIONS',
            'headline' => 'THE WORLD, FROM A NEW PERSPECTIVE',
            'description' => 'Find your own rhythm among the Mediterranean’s storied coastlines and the Caribbean’s clear-water islands. Your itinerary begins with what inspires you.',
            'image' => 'dest-main.jpg',
            'story_image' => 'intro-2.jpg',
            'highlights' => [
                ['title' => 'The Mediterranean', 'body' => 'Discover celebrated coastlines, quiet anchorages and long evenings ashore from the Amalfi Coast to the Balearics.', 'image' => 'dest-med.jpg'],
                ['title' => 'The Caribbean & Bahamas', 'body' => 'Spend unhurried days among turquoise shallows, powder-soft beaches and welcoming island communities.', 'image' => 'dest-carib.jpg'],
                ['title' => 'A journey of your own', 'body' => 'Share your dates and interests with our team and we will help shape a route around the places you most want to see.', 'image' => 'island.jpg'],
            ],
        ],
        'sell' => [
            'eyebrow' => 'SELL YOUR YACHT',
            'headline' => 'THE RIGHT NEXT CHAPTER',
            'description' => 'A thoughtful sale starts with a clear understanding of your yacht and your priorities. We bring market insight and a personal approach to every conversation.',
            'image' => 'yacht-6.jpg',
            'story_image' => 'yacht-1.jpg',
            'highlights' => [
                ['title' => 'A considered strategy', 'body' => 'We help position your yacht with a tailored approach informed by the market and its individual story.', 'image' => 'yacht-2.jpg'],
                ['title' => 'The right introductions', 'body' => 'Connect with a qualified international audience through our established network and trusted relationships.', 'image' => 'yacht-4.jpg'],
                ['title' => 'Support through closing', 'body' => 'From the first valuation discussion to the final handover, our team helps you navigate each step.', 'image' => 'yacht-5.jpg'],
            ],
        ],
        'management' => [
            'eyebrow' => 'YACHT MANAGEMENT',
            'headline' => 'MORE TIME FOR THE MOMENTS THAT MATTER',
            'description' => 'Expert yacht management brings peace of mind on shore and at sea. We help coordinate the details that keep your yacht ready for what comes next.',
            'image' => 'yacht-3.jpg',
            'story_image' => 'yacht-5.jpg',
            'highlights' => [
                ['title' => 'Operational oversight', 'body' => 'A proactive approach to day-to-day operations helps keep your yacht running smoothly.', 'image' => 'yacht-2.jpg'],
                ['title' => 'Care for your investment', 'body' => 'Coordinate maintenance, refit planning and trusted technical support around your yacht’s needs.', 'image' => 'yacht-6.jpg'],
                ['title' => 'A team in your corner', 'body' => 'Stay informed with a dedicated point of contact who understands your priorities and plans.', 'image' => 'yacht-4.jpg'],
            ],
        ],
        'crew' => [
            'eyebrow' => 'CREW SERVICES',
            'headline' => 'THE PEOPLE WHO MAKE IT EXTRAORDINARY',
            'description' => 'The right crew brings a yacht to life. We help owners and captains connect with talented professionals who share a commitment to exceptional service.',
            'image' => 'summer.jpg',
            'story_image' => 'yacht-4.jpg',
            'highlights' => [
                ['title' => 'Thoughtful introductions', 'body' => 'Find experienced crew whose skills and approach suit your yacht and its culture.', 'image' => 'yacht-2.jpg'],
                ['title' => 'Support for owners', 'body' => 'Discuss your requirements with a team that understands the people and practicalities behind life on board.', 'image' => 'yacht-5.jpg'],
                ['title' => 'A lasting fit', 'body' => 'We value clear communication and personal connections that help build successful working relationships.', 'image' => 'yacht-3.jpg'],
            ],
        ],
        'about' => [
            'eyebrow' => 'ABOUT LUXORA',
            'headline' => 'A WORLD OF POSSIBILITY, PERSONALLY CONSIDERED',
            'description' => 'Luxora Yachts brings people, places and expertise together to make life on the water more meaningful. Every journey begins by listening.',
            'image' => 'hero.jpg',
            'story_image' => 'intro-1.jpg',
            'highlights' => [
                ['title' => 'Personal by nature', 'body' => 'We take time to understand what matters to you, then shape our advice around your ambitions.', 'image' => 'intro-2.jpg'],
                ['title' => 'Connected around the world', 'body' => 'Our relationships and local knowledge help open doors to remarkable yachts and destinations.', 'image' => 'dest-main.jpg'],
                ['title' => 'Here for the journey', 'body' => 'From your first question to your next adventure, our team is here to make the details feel easy.', 'image' => 'yacht-1.jpg'],
            ],
        ],
        'news' => [
            'eyebrow' => 'JOURNAL',
            'headline' => 'NOTES FROM A LIFE ON THE WATER',
            'description' => 'Explore ideas, inspiration and perspectives from the world of yachting, from destinations worth lingering in to the details that make a journey unforgettable.',
            'image' => 'art-of-leaving.jpg',
            'story_image' => 'dest-med.jpg',
            'highlights' => [
                ['title' => 'The art of leaving', 'body' => 'Discover the pleasure of slowing down and finding a new perspective from the water.', 'image' => 'island.jpg'],
                ['title' => 'Summer in the Mediterranean', 'body' => 'A season of warm evenings, hidden coves and time well spent along the coast.', 'image' => 'summer.jpg'],
                ['title' => 'Places to return to', 'body' => 'From the timeless Mediterranean to the colour of the Caribbean, find inspiration for your next escape.', 'image' => 'dest-carib.jpg'],
            ],
        ],
        'careers' => [
            'eyebrow' => 'CAREERS',
            'headline' => 'HELP SHAPE WHAT COMES NEXT',
            'description' => 'We believe the best experiences begin with curious, thoughtful people. If you care about exceptional service and the world of yachting, we would love to hear from you.',
            'image' => 'island.jpg',
            'story_image' => 'yacht-6.jpg',
            'highlights' => [
                ['title' => 'A shared standard', 'body' => 'Bring care, integrity and curiosity to a team that takes pride in getting the details right.', 'image' => 'yacht-3.jpg'],
                ['title' => 'A global perspective', 'body' => 'Be part of a connected world of clients, colleagues and partners across the yachting community.', 'image' => 'dest-main.jpg'],
                ['title' => 'Start a conversation', 'body' => 'Tell us about your experience and what you hope to bring to Luxora Yachts.', 'image' => 'intro-2.jpg'],
            ],
        ],
    ];

    public static function editableContentPages(): array
    {
        $pages = [
            'home' => [
                'label' => 'Homepage',
                'content' => [
                    'headline' => "LIMITLESS\nEXPLORATION.\nUNPARALLELED\nLUXURY.",
                    'description' => 'Centuries of expertise, dedicated to delivering today’s most extraordinary yachting experiences.',
                    'image' => 'hero.jpg',
                ],
            ],
            'charter' => [
                'label' => 'Charter',
                'content' => [
                    'eyebrow' => 'YOUR OWN WAY TO SEE THE WORLD',
                    'headline' => "THE SEA,\nALL YOURS.",
                    'description' => 'Private yachts. Remarkable places. A journey shaped entirely around you.',
                    'image' => 'charter-hero.jpg',
                ],
            ],
        ];

        foreach (self::EXPERIENCE_PAGES as $slug => $page) {
            $pages[$slug] = [
                'label' => $page['eyebrow'],
                'content' => [
                    'eyebrow' => $page['eyebrow'],
                    'headline' => $page['headline'],
                    'description' => $page['description'],
                    'image' => $page['image'],
                    'story_title' => $page['story_title'] ?? 'EXPERTISE THAT STARTS WITH YOU',
                    'story_description' => $page['story_description'] ?? 'Every yacht and every journey is different. We take the time to understand what matters to you, then bring together the people, knowledge and details to make it happen.',
                ],
            ];
        }

        return $pages;
    }

    private const EXPERIENCE_FAQS = [
        'buy' => [
            ['question' => 'What should I decide before looking at yachts?', 'answer' => 'Start with how often you expect to cruise, where you want to go, who will join you and how much time you want to spend aboard. Those answers help shape a practical brief.'],
            ['question' => 'What checks belong in a yacht purchase?', 'answer' => 'Independent technical and marine surveys, a review of title and ownership records, and advice from qualified legal and tax professionals are important parts of due diligence.'],
            ['question' => 'Are the profiles in the catalogue yachts for sale?', 'answer' => 'No. The online profiles are illustrative examples only. Contact our team for current opportunities and confirmed details.'],
        ],
        'build' => [
            ['question' => 'How do I begin planning a new build?', 'answer' => 'Write down how you expect to use the yacht, the number of guests and crew, preferred cruising areas, and an initial budget and delivery window.'],
            ['question' => 'When should a shipyard be selected?', 'answer' => 'Bring the shipyard into the process early enough to test feasibility, capacity, schedule and build approach against the brief before major commitments are made.'],
            ['question' => 'Can the design change during construction?', 'answer' => 'Changes may affect cost, approvals, materials and delivery timing. A clear change-control process helps the owner and project team assess each request before it is accepted.'],
        ],
        'design' => [
            ['question' => 'What is the difference between a refit and a redesign?', 'answer' => 'A refit may focus on maintenance or targeted upgrades; a redesign can reshape spaces, systems or the overall onboard experience. The right scope depends on the yacht and intended use.'],
            ['question' => 'How do I keep a design practical at sea?', 'answer' => 'Consider movement, storage, maintenance, access and the realities of the yacht’s systems alongside materials, lighting and appearance.'],
            ['question' => 'What should I prepare before a design consultation?', 'answer' => 'Bring photos or references you like, a list of onboard frustrations, priorities for guests and crew, and any timing or operational constraints.'],
        ],
        'destinations' => [
            ['question' => 'When is the best time to plan a yacht itinerary?', 'answer' => 'Start with your preferred travel window, then compare seasonal weather, local events, daylight and the destinations that are practical for that period.'],
            ['question' => 'Can an itinerary change while we are aboard?', 'answer' => 'A flexible route can often be discussed with the captain, subject to weather, safety, yacht capability, local rules and confirmed arrangements ashore.'],
            ['question' => 'How should I choose between the Mediterranean and Caribbean?', 'answer' => 'Think about the scenery, activities, culture and pace you want. A specialist can help weigh those preferences against seasonality and your travel dates.'],
        ],
        'sell' => [
            ['question' => 'What information helps prepare a yacht for sale?', 'answer' => 'A current specification, maintenance and refit records, ownership documentation, recent photographs and a clear picture of any known work help establish a useful starting point.'],
            ['question' => 'How is an asking price determined?', 'answer' => 'Comparable vessels, condition, equipment, maintenance history and current market context all matter. A valuation should be discussed with a qualified yacht professional.'],
            ['question' => 'How long does selling a yacht take?', 'answer' => 'Timing varies with the vessel, market, buyer due diligence and transaction terms. A realistic plan should allow time for viewings, surveys and closing.'],
        ],
        'management' => [
            ['question' => 'What can yacht management include?', 'answer' => 'Depending on the arrangement, support may cover operational planning, maintenance coordination, budgeting, compliance administration and communication with the crew and suppliers.'],
            ['question' => 'How often should a yacht maintenance plan be reviewed?', 'answer' => 'Review it regularly with the captain and relevant technical professionals, and update it after inspections, significant use, changes in regulations or new owner priorities.'],
            ['question' => 'Does management replace the captain or technical advisers?', 'answer' => 'No. Responsibilities depend on the agreement, and operational decisions remain with the appropriate qualified people aboard and ashore.'],
        ],
        'crew' => [
            ['question' => 'What should I consider when hiring yacht crew?', 'answer' => 'Role-specific experience, valid qualifications, references, communication style and fit with the yacht’s operation all deserve careful review.'],
            ['question' => 'How do crew needs change with yacht size?', 'answer' => 'Guest capacity, operating profile, itinerary and onboard services influence the roles and staffing required. Confirm needs with qualified maritime professionals.'],
            ['question' => 'What information should be ready for a crew search?', 'answer' => 'Prepare the role description, yacht and itinerary details, expected start date, required credentials, employment terms and the process for checking references.'],
        ],
        'about' => [
            ['question' => 'How does Luxora approach a new client brief?', 'answer' => 'We begin by listening to your priorities and clarifying the practical details, then connect the conversation to the service or specialist that best fits.'],
            ['question' => 'Can I discuss more than one yachting service?', 'answer' => 'Yes. Ownership, charter, design, sale and management questions can overlap; share the full picture so the next step is useful.'],
            ['question' => 'Are the yachts shown on this site confirmed listings?', 'answer' => 'No. Catalogue profiles are illustrative examples. Current availability, specifications and commercial terms must be confirmed directly.'],
        ],
        'news' => [
            ['question' => 'How often is the journal updated?', 'answer' => 'New editorial features are added as stories and insights are ready. Subscribe to the newsletter for updates from Luxora.'],
            ['question' => 'Can I suggest a topic for a future story?', 'answer' => 'Yes. Send the subject and what you would like to learn through the contact page, and the editorial team can consider it for a future feature.'],
            ['question' => 'Are editorial features a source of live yacht availability?', 'answer' => 'No. Articles are for inspiration and general information; confirm yacht details and availability with the relevant professional.'],
        ],
        'careers' => [
            ['question' => 'What should I include in an introduction?', 'answer' => 'Tell us about your relevant experience, the kind of work you are interested in and how you would contribute to thoughtful service.'],
            ['question' => 'Are all roles listed on this page currently open?', 'answer' => 'No. This page introduces our approach and invites a conversation; it is not a live vacancy list.'],
            ['question' => 'Can maritime professionals get in touch?', 'answer' => 'Yes. Please include your area of experience, relevant credentials and preferred location or type of role.'],
        ],
    ];

    public function home()
    {
        return view('pages.home', [
            'siteContent' => $this->pageContent('home'),
        ]);
    }

    public function show(string $page)
    {
        abort_unless(isset(self::EXPERIENCE_PAGES[$page]), 404);

        return view('pages.experience', [
            'page' => array_merge(self::EXPERIENCE_PAGES[$page], $this->pageContent($page)),
            'faqs' => self::EXPERIENCE_FAQS[$page],
        ]);
    }

    public function charter()
    {
        return view('pages.charter', [
            'siteContent' => $this->pageContent('charter'),
        ]);
    }

    private function pageContent(string $page): array
    {
        $defaults = self::editableContentPages()[$page]['content'];
        $stored = SiteContent::query()->where('page_key', $page)->first()?->content ?? [];
        $content = array_merge($defaults, array_intersect_key($stored, $defaults));
        $image = $content['image'];
        $content['image_url'] = str_starts_with($image, 'storage/')
            ? Storage::disk(config('admin.upload_disk'))->url(substr($image, strlen('storage/')))
            : asset('images/'.$image);
        $content['video_poster_url'] = $page === 'home' && $image === $defaults['image']
            ? null
            : $content['image_url'];

        return $content;
    }

    public function contact()
    {
        return view('pages.contact', [
            'yachts' => Yacht::query()
                ->where('is_published', true)
                ->orderBy('name')
                ->pluck('name'),
            'destinations' => self::CHARTER_DESTINATIONS,
            'budgets' => self::CHARTER_BUDGETS,
            'selectedYacht' => request()->query('yacht'),
            'services' => self::ENQUIRY_SERVICES,
            'selectedService' => request()->query('service'),
        ]);
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'service' => ['nullable', Rule::in(array_keys(self::ENQUIRY_SERVICES))],
            'yacht' => ['nullable', 'string', 'max:100', Rule::exists('yachts', 'name')->where('is_published', true)],
            'destination' => ['nullable', Rule::in(self::CHARTER_DESTINATIONS)],
            'charter_start_date' => ['nullable', 'required_with:charter_end_date', 'date', 'after_or_equal:today'],
            'charter_end_date' => ['nullable', 'required_with:charter_start_date', 'date', 'after:charter_start_date'],
            'guests' => ['nullable', 'integer', 'between:1,12'],
            'budget' => ['nullable', Rule::in(self::CHARTER_BUDGETS)],
        ]);

        ContactEnquiry::create([
            ...$validated,
            'user_id' => $request->user()?->id,
        ]);

        return back()->with('sent', 'Thank you. Our team has received your enquiry.');
    }

    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'newsletter_email' => ['required', 'email', 'lowercase', 'max:255', 'unique:newsletter_subscriptions,email'],
        ]);

        NewsletterSubscription::create(['email' => $validated['newsletter_email']]);

        return back()->with('newsletter_subscribed', 'Thank you for subscribing to Luxora updates.');
    }
}
