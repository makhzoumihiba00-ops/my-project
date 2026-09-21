{{--
AGAFAY / DESERT STORIES — self-contained Laravel landing page
Place at: resources/views/landing.blade.php
Route: Route::view('/', 'landing')->name('home');

Everything is in this view: content, CSS, inline SVG icons, and application JS.
Only photography, Google Fonts, GSAP 3.13.0, and ScrollTrigger load externally.
No npm, Vite, Tailwind build, or separate public assets are required.

FULL-WIDTH LAYOUT:
No centered 1240px maximum: all section containers use fluid edge gutters.
Edit --page-gutter to adjust the desktop inset; phones use 20px (16px below 361px).
Experience cards use 4 columns from 1600px, 3 on desktop, 2 on tablet, and 1 on phones.
Body copy intentionally keeps readable line lengths; backgrounds are edge to edge.

THEME AND DECORATIONS:
Follows the browser/device light or dark preference, including changes while open.
CSS handles the theme before application JS; forms and dialogs follow it too.
Inline SVG suns, dots, arches, stars, trails, palms, and dunes are decorative,
non-focusable, locally clipped, and positioned behind all interactive content.
The account icon displays a coming-soon notice until $site['loginUrl'] is set.
Do not set that URL before a real login route is available; this view adds no auth.

CONTENT: The brand, prices, itineraries, and testimonials below are design samples.
Keep demoContent true until you have replaced them with verified business content.
Stock images are illustrative; they do not promise a particular camp or supplier.

BACKEND HANDOFF (not implemented in a view):
Pass $bookingEndpoint and $contactEndpoint from your controller once routes exist:
  return view('landing', [
    'bookingEndpoint' => route('bookings.store'),
    'contactEndpoint' => route('contact.store'),
  ]);
Both endpoints must be same-origin POST routes in the web middleware group.
A successful response must be JSON: {"success":true,"reference":"AGF-0001"}
Validation errors: HTTP 422 + {"message":"...","errors":{"email":["..."]}}
The form submits FormData, CSRF, and an Idempotency-Key header. The controller must
persist that key with a uniqueness constraint if duplicate prevention is needed.
Never trust client prices: look up package_id and calculate the quote server-side.
Validate dates, consent, phone, capacities, and activity suitability server-side.
Use throttling and spam protection. Do not log unredacted personal form data.
No visitor contact data is stored locally by this page. Only saved package IDs
are kept in localStorage. Without endpoints, forms are explicitly preview-only.
Do not remove the preview warnings merely to make an unconnected form look live.
--}}
@php
    $site = array_replace([
        'name' => 'AGAFAY',
        'tagline' => 'DESERT STORIES',
        'description' => 'Discover a different kind of day. Explore Agafay camel rides, quad adventures, slow escapes, and Moroccan tea experiences.',
        'email' => null, // Replace with the real public business email.
        'phone' => null, // Replace with the real public business phone, including country code.
        'whatsapp' => null, // Digits only, with country code. Example format: 212XXXXXXXXX.
        'loginUrl' => null, // Set to url('/login') only after your login route exists.
        'privacyUrl' => null, // Your published privacy notice; null opens the preview explanation.
        'demoContent' => true,
        'currency' => 'MAD',
        'timezone' => 'Africa/Casablanca',
    ], $site ?? []);
    $bookingEndpoint = $bookingEndpoint ?? null;
    $contactEndpoint = $contactEndpoint ?? null;
    $photos = [
        'hero' => 'https://images.pexels.com/photos/36579415/pexels-photo-36579415.jpeg',
        'camel' => 'https://images.pexels.com/photos/36579390/pexels-photo-36579390.jpeg',
        'quad' => 'https://images.pexels.com/photos/36579388/pexels-photo-36579388.jpeg',
        'camp' => 'https://images.pexels.com/photos/25447708/pexels-photo-25447708.jpeg',
        'pool' => 'https://images.pexels.com/photos/15257132/pexels-photo-15257132.png',
        'breakfast' => 'https://images.pexels.com/photos/18160499/pexels-photo-18160499.jpeg',
        'stay' => 'https://images.pexels.com/photos/15258810/pexels-photo-15258810.png',
        'picnic' => 'https://images.pexels.com/photos/36579416/pexels-photo-36579416.jpeg',
        'night' => 'https://images.pexels.com/photos/15257995/pexels-photo-15257995.png',
        'walk' => 'https://images.pexels.com/photos/35910043/pexels-photo-35910043.jpeg',
        'tea' => 'https://images.pexels.com/photos/36579351/pexels-photo-36579351.jpeg',
        'landscape' => 'https://images.pexels.com/photos/35910045/pexels-photo-35910045.jpeg',
        'rest' => 'https://images.pexels.com/photos/15258884/pexels-photo-15258884.png',
        'caravan' => 'https://images.pexels.com/photos/24193958/pexels-photo-24193958.jpeg',
        'quadwide' => 'https://images.pexels.com/photos/28076410/pexels-photo-28076410.jpeg',
    ];
    $packages = $packages ?? [
        [
            'id' => 'camel-sunset',
            'title' => 'Sunset camel ride & mint tea',
            'category' => 'adventure',
            'categoryLabel' => 'Adventure',
            'tag' => 'Golden-hour favorite',
            'price' => 350,
            'duration' => '2 hours',
            'time' => 'Late afternoon',
            'pace' => 'Gentle pace',
            'maxGuests' => 12,
            'image' => 'https://images.pexels.com/photos/36579390/pexels-photo-36579390.jpeg',
            'alt' => 'Saddled camels in the rocky Agafay landscape',
            'teaser' => 'Slow steps, wide-open skies, and a glass of something sweet.',
            'description' => 'Leave the rush behind for a gentle camel ride across the Agafay landscape. Pause for photographs as the light softens, then settle into camp for a traditional mint tea. A simple little escape with a big sense of place.',
            'includes' => [
                'Guided camel ride',
                'Mint tea at camp',
                'Photo stops along the route',
                'Welcome and orientation',
            ],
            'itinerary' => [
                [
                    'A warm welcome',
                    'Meet your host, get comfortable, and hear a short introduction to the ride.',
                ],
                [
                    'Follow the horizon',
                    'Head out with your guide for a relaxed ride and scenic photo stops.',
                ],
                [
                    'Stay for the tea',
                    'Return to camp, sip mint tea, and enjoy the last light.',
                ],
            ],
            'note' => 'The ride and departure time depend on seasonal sunset times. The operator must confirm rider suitability before your booking.',
        ],
        [
            'id' => 'quad-trails',
            'title' => 'Quad trails & desert horizons',
            'category' => 'adventure',
            'categoryLabel' => 'Adventure',
            'tag' => 'A little more adventure',
            'price' => 550,
            'duration' => '3 hours',
            'time' => 'Morning or afternoon',
            'pace' => 'Active experience',
            'maxGuests' => 8,
            'image' => 'https://images.pexels.com/photos/36579388/pexels-photo-36579388.jpeg',
            'alt' => 'Visitors with helmets and quad bikes in Agafay',
            'teaser' => 'Dusty trails, dramatic views, and your next favorite memory.',
            'description' => 'See another side of Agafay on a guided quad adventure. Start with an introduction to the equipment before following your guide across open tracks. Stop to take in the views and finish with a well-earned tea break.',
            'includes' => [
                'Guided quad route',
                'Safety briefing',
                'Helmet and protective goggles',
                'Mint tea break',
            ],
            'itinerary' => [
                [
                    'Get ready to ride',
                    'Meet your guide for equipment fitting and a practice session.',
                ],
                [
                    'Take the scenic route',
                    'Follow your guide on designated tracks with breaks for photographs.',
                ],
                [
                    'Unwind at camp',
                    'Slow things down with mint tea and a chance to share your favorite moments.',
                ],
            ],
            'note' => 'Driver age, licence requirements, passenger options, and suitability must be confirmed by the operator. The sample price assumes one guest per quad.',
        ],
        [
            'id' => 'dinner-music',
            'title' => 'Dinner beneath the desert sky',
            'category' => 'food',
            'categoryLabel' => 'Food & culture',
            'tag' => 'An evening to remember',
            'price' => 650,
            'duration' => '4 hours',
            'time' => 'Evening',
            'pace' => 'Relaxed evening',
            'maxGuests' => 12,
            'image' => 'https://images.pexels.com/photos/25447708/pexels-photo-25447708.jpeg',
            'alt' => 'Moroccan camp terrace looking over the Agafay hills',
            'teaser' => 'A beautiful setting, Moroccan flavors, and a little live music.',
            'description' => 'Trade the city lights for an evening at a desert camp. Arrive with time to enjoy the views, gather around the table for a Moroccan dinner, and settle into the atmosphere of a live music evening.',
            'includes' => [
                'Welcome mint tea',
                'Moroccan dinner menu',
                'Live music program',
                'Time to enjoy the camp',
            ],
            'itinerary' => [
                [
                    'Arrive before the evening',
                    'Explore your surroundings and enjoy your welcome tea.',
                ],
                [
                    'Gather around the table',
                    'Taste a Moroccan dinner in the camp setting.',
                ],
                [
                    'Let the evening unfold',
                    'Enjoy the planned music program before your departure.',
                ],
            ],
            'note' => 'Menus, performances, and seating arrangements are confirmed with the operator. Mention allergies or dietary preferences in your request.',
        ],
        [
            'id' => 'complete-evening',
            'title' => 'The complete Agafay evening',
            'category' => 'adventure',
            'categoryLabel' => 'Adventure',
            'tag' => 'The signature escape',
            'price' => 990,
            'duration' => '5 hours',
            'time' => 'Afternoon to evening',
            'pace' => 'Adventure + unwind',
            'maxGuests' => 8,
            'image' => 'https://images.pexels.com/photos/24193958/pexels-photo-24193958.jpeg',
            'alt' => 'Camels resting near an Agafay camp in golden evening light',
            'teaser' => 'A camel ride, a quad adventure, and dinner. All the good parts.',
            'description' => 'Make a whole afternoon of it. Combine a guided quad ride with a slower camel experience, pause for the sunset, and end the day over dinner at camp. This is the sample signature itinerary for guests who would like a little of everything.',
            'includes' => [
                'Guided quad experience',
                'Camel ride and photo stops',
                'Welcome tea',
                'Moroccan dinner at camp',
            ],
            'itinerary' => [
                [
                    'A little adventure',
                    'Begin with a briefing and a guided quad route through the landscape.',
                ],
                [
                    'A change of pace',
                    'Swap the handlebars for a camel ride and take in the evening light.',
                ],
                [
                    'Dinner with a view',
                    'Come back to camp for mint tea and a Moroccan dinner.',
                ],
            ],
            'note' => 'The order of activities may change with conditions. The operator must confirm riding eligibility, final timing, and any transfer arrangements.',
        ],
        [
            'id' => 'pool-lunch',
            'title' => 'Poolside pause & Moroccan lunch',
            'category' => 'relax',
            'categoryLabel' => 'Slow escapes',
            'tag' => 'Your out-of-office moment',
            'price' => 750,
            'duration' => 'Day access',
            'time' => 'Late morning',
            'pace' => 'Very relaxed',
            'maxGuests' => 10,
            'image' => 'https://images.pexels.com/photos/15257132/pexels-photo-15257132.png',
            'alt' => 'Swimming pool and sun loungers at a desert camp',
            'teaser' => 'A long lunch. A cool dip. Absolutely nowhere to rush.',
            'description' => 'Give your itinerary a little breathing room. Spend a leisurely day at a desert camp with pool access, time to unwind, and a Moroccan lunch. Bring a book, take a dip, and enjoy a slower kind of adventure.',
            'includes' => [
                'Daytime camp access',
                'Pool access',
                'Moroccan lunch',
                'Welcome drink',
            ],
            'itinerary' => [
                [
                    'Settle in',
                    'Arrive at the camp and find your place to unwind.',
                ],
                [
                    'Lunch, slowly',
                    'Enjoy lunch and a long, unhurried pause.',
                ],
                [
                    'Take the afternoon off',
                    'Swim or relax before the end of your day access.',
                ],
            ],
            'note' => 'The final camp, pool opening hours, towel policy, and weather arrangements are confirmed before booking. Photos illustrate the experience, not a guaranteed venue.',
        ],
        [
            'id' => 'sunrise-breakfast',
            'title' => 'Sunrise views & a slow breakfast',
            'category' => 'food',
            'categoryLabel' => 'Food & culture',
            'tag' => 'For the early birds',
            'price' => 390,
            'duration' => '3 hours',
            'time' => 'Early morning',
            'pace' => 'Gentle pace',
            'maxGuests' => 10,
            'image' => 'https://images.pexels.com/photos/18160499/pexels-photo-18160499.jpeg',
            'alt' => 'Breakfast served outdoors overlooking the Agafay landscape',
            'teaser' => 'Start your day with a quieter sky and a generous breakfast.',
            'description' => 'Wake up for something worth leaving your bed for. Enjoy the early light across the landscape, followed by a relaxed breakfast with tea or coffee. An easygoing way to begin a day away from the city.',
            'includes' => [
                'Morning camp welcome',
                'Breakfast selection',
                'Tea or coffee',
                'Scenic morning photo stop',
            ],
            'itinerary' => [
                [
                    'Catch the first light',
                    'Meet your host at the agreed time and take in the morning views.',
                ],
                [
                    'Breakfast is served',
                    'Sit down to a relaxed breakfast in the camp setting.',
                ],
                [
                    'A little time to yourself',
                    'Enjoy a short walk around camp before heading back.',
                ],
            ],
            'note' => 'Arrival time changes with the season. A visible sunrise cannot be guaranteed in cloudy weather. Share any dietary requirements in advance.',
        ],
        [
            'id' => 'overnight-camp',
            'title' => 'A night away, under canvas',
            'category' => 'relax',
            'categoryLabel' => 'Slow escapes',
            'tag' => 'Stay a little longer',
            'price' => 1490,
            'duration' => '1 night',
            'time' => 'Afternoon check-in',
            'pace' => 'Overnight escape',
            'maxGuests' => 8,
            'image' => 'https://images.pexels.com/photos/15258810/pexels-photo-15258810.png',
            'alt' => 'Warmly lit camp interior opening onto the Agafay hills',
            'teaser' => 'Sunset, starlight, and waking up somewhere a little different.',
            'description' => 'Let your desert day turn into an overnight escape. Spend the evening at camp, enjoy dinner, and wake up to breakfast with a view. Your exact tent category and sleeping arrangements will be included in the final quote.',
            'includes' => [
                'One night in a camp tent',
                'Dinner at camp',
                'Morning breakfast',
                'Welcome mint tea',
            ],
            'itinerary' => [
                [
                    'Make yourself at home',
                    'Check in to your confirmed tent and enjoy the afternoon.',
                ],
                [
                    'An evening at camp',
                    'Have dinner, take in the atmosphere, and relax.',
                ],
                [
                    'Wake up slowly',
                    'Enjoy breakfast before the agreed checkout time.',
                ],
            ],
            'note' => 'The sample per-person rate assumes two guests sharing. Single occupancy, bathrooms, tent category, and any child rates require a separate quote.',
        ],
        [
            'id' => 'private-picnic',
            'title' => 'Your own private sunset picnic',
            'category' => 'private',
            'categoryLabel' => 'Private moments',
            'tag' => 'Just your kind of evening',
            'price' => 850,
            'duration' => '3 hours',
            'time' => 'Late afternoon',
            'pace' => 'Private & relaxed',
            'maxGuests' => 8,
            'image' => 'https://images.pexels.com/photos/36579416/pexels-photo-36579416.jpeg',
            'alt' => 'Two visitors watching a vivid sunset over Agafay',
            'teaser' => 'A thoughtfully set table and a sunset to call your own.',
            'description' => 'Mark an occasion or simply make an ordinary day feel special. Request a private picnic-style setup with light Moroccan bites, tea, and time to enjoy the evening together. Tell us what you are celebrating so the final proposal can reflect it.',
            'includes' => [
                'Private picnic-style setup',
                'Light Moroccan bites',
                'Mint tea',
                'Sunset photo time',
            ],
            'itinerary' => [
                [
                    'Make it personal',
                    'Confirm the setup and any special requests before your visit.',
                ],
                [
                    'Your table is ready',
                    'Arrive and settle into your private picnic area.',
                ],
                [
                    'Savor the moment',
                    'Enjoy your refreshments and the changing evening light.',
                ],
            ],
            'note' => 'Flowers, decorations, photography, and special menus are optional extras. The exact setup, minimum spend, and final price are confirmed individually.',
        ],
        [
            'id' => 'stars-tea',
            'title' => 'Stargazing & a fireside tea',
            'category' => 'relax',
            'categoryLabel' => 'Slow escapes',
            'tag' => 'After the sun goes down',
            'price' => 450,
            'duration' => '3 hours',
            'time' => 'After dusk',
            'pace' => 'Quiet evening',
            'maxGuests' => 12,
            'image' => 'https://images.pexels.com/photos/15257995/pexels-photo-15257995.png',
            'alt' => 'Agafay camp and distant mountains in the soft light of dusk',
            'teaser' => 'Put your phone away. There is a whole sky to look at.',
            'description' => 'Enjoy the quieter side of camp after dusk. Settle in with a glass of tea and take time to look up at the night sky. This is an informal evening experience, not a guaranteed astronomy session or telescope tour.',
            'includes' => [
                'Evening camp access',
                'Mint tea and light snacks',
                'Informal sky viewing',
                'Hosted evening welcome',
            ],
            'itinerary' => [
                [
                    'Arrive at dusk',
                    'Meet your host as the camp settles into the evening.',
                ],
                [
                    'Tea and conversation',
                    'Enjoy tea and light snacks in a relaxed setting.',
                ],
                [
                    'Look up for a while',
                    'Take in the night sky when visibility permits.',
                ],
            ],
            'note' => 'Sky visibility depends on cloud, moonlight, and local conditions. A fire is only used when permitted and appropriate. Telescope equipment is not included.',
        ],
        [
            'id' => 'walk-tea',
            'title' => 'Desert paths & the art of tea',
            'category' => 'adventure',
            'categoryLabel' => 'Adventure',
            'tag' => 'The simple things',
            'price' => 290,
            'duration' => '2 hours',
            'time' => 'Morning or afternoon',
            'pace' => 'Walking experience',
            'maxGuests' => 10,
            'image' => 'https://images.pexels.com/photos/35910043/pexels-photo-35910043.jpeg',
            'alt' => 'A walker surrounded by the rolling rocky hills of Agafay',
            'teaser' => 'Explore on foot, take in the silence, and finish with mint tea.',
            'description' => 'Get to know the landscape one step at a time on a guided walk. Follow a route suited to your group, stop for photographs, and end with an introduction to a Moroccan mint tea ritual back at camp.',
            'includes' => [
                'Guided landscape walk',
                'Scenic photo stops',
                'Mint tea preparation',
                'Tea tasting at camp',
            ],
            'itinerary' => [
                [
                    'Choose your pace',
                    'Meet your guide and agree on a suitable route.',
                ],
                [
                    'Take the long view',
                    'Walk through the landscape with time to stop and look around.',
                ],
                [
                    'Learn the tea ritual',
                    'Return to camp to enjoy freshly prepared mint tea.',
                ],
            ],
            'note' => 'Route length and difficulty depend on your group and conditions. Tell the operator about mobility needs so suitability can be checked before booking.',
        ],
    ];
    $reviews = $reviews ?? [
        [
            'name' => 'Emma L.',
            'initials' => 'EL',
            'trip' => 'Sunset camel ride & mint tea',
            'quote' => 'The kind of evening you wish you could bottle. The light, the quiet, the tea at the end — such a lovely change of pace.',
            'color' => 'peach',
        ],
        [
            'name' => 'James & Mia',
            'initials' => 'JM',
            'trip' => 'The complete Agafay evening',
            'quote' => 'A little adventure, a beautiful sunset, and a long dinner together. This is exactly the kind of day we travel for.',
            'color' => 'olive',
        ],
        [
            'name' => 'Sofia R.',
            'initials' => 'SR',
            'trip' => 'Poolside pause & Moroccan lunch',
            'quote' => 'We left room for one slow day on our trip. A book by the pool and lunch with that view would be hard to beat.',
            'color' => 'sand',
        ],
    ];
    $faqs = [
        [
            'How does a booking request work?',
            'Choose an experience, select your preferred date and group size, and complete the short form. Once live booking is connected, the operator can contact you to confirm availability, the final price, and the meeting details. A request is not a confirmed booking.',
        ],
        [
            'Is pickup from Marrakech included?',
            'The sample prices do not include transfers. Add your hotel or riad to the request so the operator can discuss pickup options and the cost. Always wait for your confirmed pickup location and time before travelling.',
        ],
        [
            'Can I request a private or custom experience?',
            'Yes. Use the contact form to describe your group, preferred date, and the kind of day you have in mind. A private itinerary, special occasion, or combination of activities can be discussed with the operator.',
        ],
        [
            'Are the activities suitable for children?',
            'Suitability varies by activity, age, and the operator’s rules. Mention children’s ages and any accessibility needs in your request. Riding activities require the operator’s approval; do not assume every guest can participate.',
        ],
        [
            'What happens if plans or the weather change?',
            'The operator needs to confirm the cancellation, rescheduling, and weather policy for your chosen experience before you book. No free cancellation or refund policy is promised by this preview.',
        ],
        [
            'Do I pay when I complete the form?',
            'No payment is collected on this page. The form is a request for availability and a final quote. In preview mode, the form only demonstrates the process and does not send or save your details.',
        ],
    ];
    $iconPaths = [
        'user' => '<circle cx="12" cy="8" r="3.5"/><path d="M5 21v-1a7 7 0 0 1 14 0v1"/>',
        'arrow' => '<path d="M5 12h14m-6-6 6 6-6 6"/>',
        'arrow-up' => '<path d="M6 18 18 6M6 6h12v12"/>',
        'chevron' => '<path d="m6 9 6 6 6-6"/>',
        'chevron-right' => '<path d="m9 6 6 6-6 6"/>',
        'sun' => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M2 12h2m16 0h2M5 5l1.5 1.5m11 11L19 19M5 19l1.5-1.5m11-11L19 5"/>',
        'sunset' => '<path d="M3 17h18M5 21h14M7 17a5 5 0 0 1 10 0M12 2v3M3 9l2 2m14 0 2-2M12 8v3m-2-1 2 2 2-2"/>',
        'pin' => '<path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'calendar' => '<rect x="3" y="5" width="18" height="16" rx="3"/><path d="M7 3v4m10-4v4M3 11h18m-14 4h2m4 0h2"/>',
        'users' => '<circle cx="9" cy="8" r="3"/><path d="M3 21v-2a6 6 0 0 1 12 0v2M16 5a3 3 0 0 1 0 6m2 4a5 5 0 0 1 3 4v2"/>',
        'heart' => '<path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8L12 21l8.8-8.6a5.5 5.5 0 0 0 0-7.8Z"/>',
        'compass' => '<circle cx="12" cy="12" r="9"/><path d="m16 8-2.5 5.5L8 16l2.5-5.5L16 8Z"/>',
        'cup' => '<path d="M4 9h13v6a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V9Zm13 0h1a3 3 0 0 1 0 6h-1M7 3v3m4-3v3m4-3v3M2 23h19"/>',
        'leaf' => '<path d="M20 3c-4 0-7-2-12 3-5 5-3 10 1 12 4 2 11-1 11-9V3ZM3 21 15 9"/>',
        'moon' => '<path d="M21 13a9 9 0 0 1-10-10A9 9 0 1 0 21 13Z"/>',
        'check' => '<path d="m5 12 4 4L19 6"/>',
        'shield' => '<path d="m12 2 9 4v6c0 5-9 10-9 10S3 17 3 12V6l9-4Z"/><path d="m8 12 3 3 5-6"/>',
        'chat' => '<path d="M21 11a9 9 0 0 1-9 9H4l-3 2 2-6a9 9 0 1 1 18-5Z"/><path d="M8 10h8m-8 4h5"/>',
        'mail' => '<rect x="2" y="4" width="20" height="16" rx="3"/><path d="m3 6 9 7 9-7"/>',
        'phone' => '<path d="M5 3h4l2 5-3 2a15 15 0 0 0 6 6l2-3 5 2v4a2 2 0 0 1-2 2C10 21 3 14 3 5a2 2 0 0 1 2-2Z"/>',
        'menu' => '<path d="M4 6h16M4 12h16M4 18h16"/>',
        'close' => '<path d="m6 6 12 12M6 18 18 6"/>',
        'plus' => '<path d="M12 5v14M5 12h14"/>',
        'minus' => '<path d="M5 12h14"/>',
        'search' => '<circle cx="10.5" cy="10.5" r="7.5"/><path d="m16 16 5 5"/>',
        'info' => '<circle cx="12" cy="12" r="9"/><path d="M12 11v6m0-10v.1"/>',
        'sparkle' => '<path d="m12 3 2.5 6.5L21 12l-6.5 2.5L12 21l-2.5-6.5L3 12l6.5-2.5L12 3Z"/>',
        'quote' => '<path d="M10 5H4v7h5c0 4-2 5-4 6M21 5h-6v7h5c0 4-2 5-4 6"/>',
        'star' => '<path d="m12 2 3 6 7 1-5 5 1 7-6-3-6 3 1-7-5-5 7-1 3-6Z"/>',
    ];
    $icon = static function ($name, $class = '') use ($iconPaths) {
        if (!isset($iconPaths[$name])) { return ''; }
        return '<svg class="icon '.htmlspecialchars($class, ENT_QUOTES, 'UTF-8').'" aria-hidden="true" focusable="false"><use href="#i-'.htmlspecialchars($name, ENT_QUOTES, 'UTF-8').'"></use></svg>';
    };
    $img = static function ($url, $width = 900) {
        return $url.'?auto=compress&cs=tinysrgb&w='.(int) $width.'&q=82';
    };
    $money = static function ($amount) use ($site) {
        return $site['currency'].' '.number_format((float) $amount, 0, '.', ',');
    };
    $categories = ['all' => 'All experiences', 'adventure' => 'Adventure', 'food' => 'Food & culture', 'relax' => 'Slow escapes', 'private' => 'Private moments'];
    $featuredPackage = null;
    foreach ($packages as $candidate) {
        if ($candidate['id'] === 'complete-evening') { $featuredPackage = $candidate; break; }
    }
    $client = [
        'packages' => array_values($packages),
        'bookingEndpoint' => $bookingEndpoint,
        'contactEndpoint' => $contactEndpoint,
        'currency' => $site['currency'],
        'timezone' => $site['timezone'],
        'demoContent' => (bool) $site['demoContent'],
    ];
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="#faf8f3" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#141c18" media="(prefers-color-scheme: dark)">
    <meta name="description" content="{{ $site['description'] }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $site['name'] }} — A different kind of day</title>
    @if ($site['demoContent'])
    <meta name="robots" content="noindex,nofollow">
    @endif
    <meta property="og:title" content="{{ $site['name'] }} — A different kind of day">
    <meta property="og:description" content="{{ $site['description'] }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ $img($photos['hero'], 1600) }}">
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='16' fill='%232d3c32'/%3E%3Ccircle cx='32' cy='25' r='11' fill='%23ead4b2'/%3E%3Cpath d='M10 45Q28 25 54 45M10 52Q33 35 54 49' fill='none' stroke='%23ead4b2' stroke-width='3'/%3E%3C/svg%3E">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://images.pexels.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="preload" as="image" href="{{ $img($photos['hero'], 1920) }}" imagesrcset="{{ $img($photos['hero'], 800) }} 800w, {{ $img($photos['hero'], 1280) }} 1280w, {{ $img($photos['hero'], 1920) }} 1920w" imagesizes="100vw" fetchpriority="high">
    <style>
        /* 01. Design tokens and a small, dependency-free reset */
        :root {
            --paper:#faf8f3; --white:#fff; --sand:#f0e9dd; --sand-deep:#e8ddcc;
            --ink:#28372d; --muted:#677064; --terracotta:#a84e31; --terra-hover:#8c3c25;
            --line:#e3e3d9; --green:#2e4033; --green-soft:#eaf0e6; --gold:#e0ba83;
            --serif:'DM Serif Display',Georgia,'Times New Roman',serif;
            --sans:'DM Sans',Arial,sans-serif; --radius:20px; --header-height:88px;
            --shadow:0 16px 50px rgba(46,49,32,.07);
            --page-gutter:clamp(24px,3vw,64px);
        }
        *,*::before,*::after {box-sizing:border-box}
        html {scroll-behavior:smooth;scroll-padding-top:112px;-webkit-text-size-adjust:100%}
        body {margin:0;background:var(--paper);color:var(--ink);font:400 15px/1.7 var(--sans);overflow-x:clip}
        button,input,select,textarea {font:inherit;color:inherit}
        button,a,input,select,textarea,summary {-webkit-tap-highlight-color:transparent}
        button,a,summary {touch-action:manipulation}
        button {cursor:pointer}
        button {border:0;background:none;padding:0}
        button:disabled {cursor:not-allowed;opacity:.55}
        input,select,textarea {min-width:0;max-width:100%}
        select {cursor:pointer}
        textarea {resize:vertical}
        a {color:inherit;text-decoration:none}
        img {display:block;max-width:100%;height:auto}
        h1,h2,h3,h4,p,figure,blockquote {margin:0}
        h1,h2,h3 {font-weight:400}
        h1,h2 {font-family:var(--serif);line-height:1.08;letter-spacing:-1.6px}
        h2 {font-size:clamp(36px,4.2vw,58px)}
        h2 em {font-weight:400;color:var(--terracotta)}
        p {color:var(--muted)}
        ul,ol {margin:0;padding:0;list-style:none}
        ::selection {background:#e9c5a5;color:#263329}
        :focus-visible {outline:3px solid var(--terracotta);outline-offset:5px;border-radius:4px}
        [hidden] {display:none!important}
        .container {width:calc(100% - var(--page-gutter) - var(--page-gutter));max-width:none;margin-inline:auto}
        .section {padding-block:105px}
        .icon {display:inline-block;width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:1.65;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0;vertical-align:middle}
        .sr-only {position:absolute!important;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
        .skip-link {position:fixed;left:20px;top:-100px;background:var(--green);color:#fff;padding:12px 20px;border-radius:8px;z-index:9999}
        .skip-link:focus {top:12px}
        .eyebrow {display:flex;align-items:center;gap:10px;font-size:10px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:var(--terracotta);margin-bottom:19px;line-height:1.5}
        .eyebrow::before {content:'';height:1px;width:28px;background:currentColor;flex-shrink:0}
        .section-intro {max-width:480px;margin-top:24px;font-size:16px;line-height:1.85}
        .button {display:inline-flex;align-items:center;justify-content:center;gap:16px;min-height:52px;border:1px solid transparent;border-radius:9px;padding:13px 22px;font-weight:600;font-size:13px;line-height:1.3;transition:background .2s,transform .2s,border-color .2s;white-space:normal;text-align:center}
        .button .icon {width:18px;height:18px;transition:transform .2s}
        .button:hover .icon {transform:translateX(3px)}
        .button-primary {background:var(--terracotta);color:#fff}
        .button-primary:hover {background:var(--terra-hover);transform:translateY(-2px)}
        .button-green {background:var(--green);color:#fff}
        .button-green:hover {background:#1d2c22;transform:translateY(-2px)}
        .button-light {background:#fff;color:var(--ink)}
        .button-light:hover {background:var(--sand)}
        .button-outline {border-color:var(--line);background:transparent;color:var(--ink)}
        .button-outline:hover {background:var(--sand);border-color:var(--sand-deep)}
        .text-link {display:inline-flex;align-items:center;gap:14px;font-weight:600;font-size:13px;min-height:44px}
        .text-link .icon {width:17px;height:17px}
        .text-link:hover {color:var(--terracotta)}
        .icon-button {display:inline-flex;justify-content:center;align-items:center;width:44px;height:44px;border:1px solid var(--line);border-radius:50%;background:#fff;flex-shrink:0;transition:background .2s}
        .icon-button:hover {background:var(--sand)}
        .icon-button .icon {width:18px;height:18px}
        .muted {color:var(--muted)}
        .preview-strip {background:var(--green);color:#eef0e7;text-align:center;padding:6px 18px;font-size:10px;letter-spacing:.3px;line-height:1.55}
        .preview-strip strong {font-weight:600}
        /* 02. Navigation */
        .site-header {position:sticky;top:0;z-index:30;background:rgba(250,248,243,.96);border-bottom:1px solid transparent;backdrop-filter:blur(16px);transition:box-shadow .25s,border-color .25s}
        .site-header.scrolled {box-shadow:0 5px 25px #2432210a;border-color:var(--line)}
        .nav-bar {height:var(--header-height);display:flex;align-items:center;justify-content:space-between;gap:25px}
        .brand {display:inline-flex;align-items:center;gap:11px;flex-shrink:0}
        .brand-symbol {width:43px;height:43px;color:var(--terracotta);flex-shrink:0}
        .brand-name {font-size:23px;letter-spacing:3.5px;font-weight:700;line-height:1.2;display:block}
        .brand-tagline {display:block;font-size:8px;letter-spacing:2.4px;margin-top:4px;line-height:1.2}
        .nav-links {display:flex;align-items:center;gap:30px}
        .nav-links a {font-size:12px;font-weight:500;display:inline-flex;align-items:center;min-height:44px;position:relative}
        .nav-links a::after {content:'';height:2px;position:absolute;bottom:7px;left:0;right:0;background:var(--terracotta);transform:scaleX(0);transform-origin:left;transition:transform .2s}
        .nav-links a:hover::after,.nav-links a[aria-current="location"]::after {transform:scaleX(1)}
        .nav-actions {display:flex;align-items:center;gap:13px}
        .nav-actions .button {min-height:44px;padding:12px 18px;font-size:12px}
        .menu-toggle {display:none}
        .mobile-menu {display:none}
        /* 03. Hero, discovery form and benefit strip */
        .hero {width:100%;max-width:none;margin:0;position:relative;isolation:isolate;overflow:hidden;border-radius:0;background:#6b513a;color:#fff}
        .hero-photo {position:absolute;inset:-5% 0;width:100%;height:110%;object-fit:cover;object-position:center 53%;z-index:-2}
        .hero::before {content:'';position:absolute;inset:0;z-index:-1;background:linear-gradient(90deg,rgba(26,31,24,.62),rgba(34,35,27,.18) 68%),linear-gradient(0deg,rgba(25,31,24,.38),transparent 60%)}
        .hero-inner {min-height:695px;padding-block:92px 122px;display:grid;grid-template-columns:1fr 305px;gap:50px;align-items:center}
        .hero-copy {max-width:780px}
        .hero .eyebrow {color:#fff0dc;font-size:10px;letter-spacing:2.2px;margin-bottom:28px}
        .hero h1 {font-size:clamp(58px,6.5vw,91px);letter-spacing:-2.8px;line-height:1.015}
        .hero-line {display:block}
        .hero h1 em {font-weight:400;color:#f4d6ad}
        .hero-copy>p {max-width:405px;color:#f0efea;font-size:15px;line-height:1.8;margin-top:25px}
        .hero-actions {display:flex;gap:23px;align-items:center;flex-wrap:wrap;margin-top:33px}
        .hero-actions .button {background:#fff9f0;color:var(--ink);padding-inline:24px}
        .hero-actions .button:hover {background:#fff;transform:translateY(-2px)}
        .hero-actions .text-link {color:#fff;font-size:12px}
        .hero-actions .text-link .icon {transform:rotate(90deg)}
        .hero-side {align-self:stretch;display:flex;flex-direction:column;justify-content:space-between;align-items:flex-end;padding-top:10px}
        .hero-seal {height:116px;width:116px;display:flex;flex-direction:column;align-items:center;justify-content:center;border:1px solid #fff8;border-radius:50%;transform:rotate(10deg);color:#fff2dd}
        .hero-seal span {font-size:9px;letter-spacing:1.6px;text-transform:uppercase;line-height:1.5}
        .hero-seal .icon {width:32px;height:32px;margin:7px 0}
        .hero-postcard {display:flex;width:290px;gap:15px;padding:13px;background:rgba(255,255,255,.13);backdrop-filter:blur(12px);border:1px solid #fff5;border-radius:12px;text-align:left;color:#fff;transition:background .2s,transform .2s}
        .hero-postcard:hover {background:rgba(255,255,255,.24);transform:translateY(-3px)}
        .hero-postcard img {width:76px;height:89px;object-fit:cover;border-radius:7px}
        .hero-postcard .postcard-copy {display:flex;flex-direction:column;justify-content:center;gap:5px}
        .hero-postcard small {font-size:8px;letter-spacing:1.5px;text-transform:uppercase;color:#fff5db}
        .hero-postcard strong {font-family:var(--serif);font-size:23px;line-height:1.12;font-weight:400}
        .hero-postcard .postcard-link {font-size:10px;display:flex;align-items:center;gap:12px;margin-top:4px}
        .hero-postcard .icon {width:14px;height:14px}
        .hero-caption {position:absolute;bottom:71px;right:var(--page-gutter);display:flex;align-items:center;gap:8px;font-size:9px;letter-spacing:.5px;color:#f4e5d3}
        .hero-caption .icon {width:13px;height:13px}
        .finder-wrap {position:relative;z-index:4;margin-top:-43px}
        .finder {background:#fff;display:grid;grid-template-columns:1.25fr 1.05fr .8fr auto;border:1px solid #efece5;border-radius:14px;padding:17px;box-shadow:0 14px 40px #343c2610;align-items:center}
        .finder-field {display:flex;align-items:center;gap:14px;padding:3px 22px;border-right:1px solid var(--line);min-width:0}
        .finder-field>.icon {color:var(--terracotta);width:22px;height:22px}
        .finder-field>div {min-width:0;flex:1}
        .finder label {display:block;font-size:9px;letter-spacing:1.3px;text-transform:uppercase;font-weight:700;line-height:1.5}
        .finder input,.finder select {border:0;background:transparent;width:100%;padding:5px 20px 2px 0;min-height:31px;font-size:13px;color:#62695f;border-radius:4px}
        .finder input[type=date] {padding-right:2px}
        .finder .button {margin-left:19px;min-height:58px;padding-inline:27px}
        .benefit-strip {display:grid;grid-template-columns:repeat(3,1fr);padding:38px 0 37px;border-bottom:1px solid var(--line)}
        .benefit {display:flex;justify-content:center;align-items:center;gap:13px}
        .benefit:not(:last-child) {border-right:1px solid var(--line)}
        .benefit .icon {color:var(--terracotta);width:23px;height:23px}
        .benefit strong {display:block;font-weight:500;font-size:12px;line-height:1.5}
        .benefit span {display:block;font-size:10px;color:var(--muted);line-height:1.6}
        /* 04. About: layered editorial photography */
        .about-grid {display:grid;grid-template-columns:1fr 1fr;gap:95px;align-items:center}
        .about-photos {height:535px;position:relative;margin-right:15px}
        .about-main {width:77%;height:470px;border-radius:170px 170px 12px 12px;object-fit:cover;object-position:center}
        .about-secondary {position:absolute;right:0;bottom:0;width:49%;height:280px;object-fit:cover;border-radius:110px 110px 12px 12px;border:7px solid var(--paper)}
        .about-caption {position:absolute;bottom:2px;left:5px;font-family:var(--serif);font-style:italic;font-size:20px;line-height:1.2;width:150px;color:var(--terracotta)}
        .about-stamp {position:absolute;right:3px;top:35px;width:105px;height:105px;border-radius:50%;background:var(--sand);display:flex;align-items:center;justify-content:center;border:1px solid var(--sand-deep);box-shadow:0 0 0 7px var(--paper)}
        .about-stamp .icon {width:48px;height:48px;stroke-width:1}
        .about-copy h2 {max-width:490px}
        .about-copy .section-intro {font-size:14px;margin-top:24px}
        .about-points {display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:27px;margin-bottom:25px}
        .about-point {display:flex;gap:10px;align-items:flex-start;font-size:12px;font-weight:500;line-height:1.65}
        .about-point .icon {color:var(--terracotta);width:17px;height:17px;margin-top:2px}
        .about-signature {border-top:1px solid var(--line);padding-top:24px;display:flex;align-items:center;justify-content:space-between;gap:15px}
        .about-signature>span {font-family:var(--serif);font-size:23px;font-style:italic;color:var(--terracotta)}
        /* 05. Package collection, filters, and cards */
        .experiences {background:#f2eee5;border-top:1px solid #eae5da;border-bottom:1px solid #eae5da}
        .section-heading {display:flex;align-items:flex-end;justify-content:space-between;gap:35px;margin-bottom:36px}
        .section-heading>p {max-width:320px;font-size:13px;line-height:1.8;padding-bottom:6px}
        .collection-toolbar {margin-bottom:26px}
        .filter-row {display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;padding-bottom:23px;border-bottom:1px solid #dcded0}
        .filter-chips {display:flex;flex-wrap:wrap;gap:7px}
        .filter-chip {font-size:11px;font-weight:500;line-height:1.4;min-height:42px;display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:10px 16px;border-radius:30px;border:1px solid #dcded0;background:transparent;transition:background .2s,border .2s,color .2s}
        .filter-chip:hover {background:#e5e8dc}
        .filter-chip[aria-pressed=true] {background:var(--green);color:#fff;border-color:var(--green)}
        .filter-chip .icon {width:14px;height:14px}
        .filter-saved {border-color:transparent}
        .collection-search-row {display:flex;align-items:center;justify-content:space-between;gap:18px;margin-top:18px}
        .collection-search {display:flex;align-items:center;gap:10px;min-width:0;width:310px}
        .collection-search .icon {width:17px;height:17px;color:#586450}
        .collection-search input {width:100%;font-size:12px;border:0;background:transparent;padding:8px 0;outline-offset:3px}
        .collection-tools {display:flex;align-items:center;gap:20px}
        .result-count {font-size:11px;color:#626b5f;white-space:nowrap}
        .sort-select {border:0;background:transparent;font-size:11px;min-height:36px;padding:6px 3px;max-width:155px}
        .packages-grid {display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:25px}
        .package-card {background:#fff;border:1px solid #e8e8de;border-radius:16px;overflow:hidden;display:flex;flex-direction:column;transition:box-shadow .25s,transform .25s}
        .package-card:hover {transform:translateY(-6px);box-shadow:0 16px 35px #28372412}
        .package-media {position:relative;aspect-ratio:1.53;background:var(--sand-deep);overflow:hidden}
        .package-image-button {height:100%;width:100%;display:block;overflow:hidden}
        .package-image-button img {width:100%;height:100%;object-fit:cover;transition:transform .65s ease}
        .package-card:hover .package-image-button img {transform:scale(1.045)}
        .package-tag {position:absolute;left:15px;top:15px;max-width:calc(100% - 78px);padding:6px 10px;background:rgba(255,255,255,.94);border-radius:5px;font-size:8px;font-weight:600;letter-spacing:.15px;pointer-events:none;line-height:1.5}
        .save-button {position:absolute;right:12px;top:12px;width:37px;height:37px;background:rgba(255,255,255,.96);border:0}
        .save-button .icon {width:16px;height:16px}
        .save-button[aria-pressed=true] {color:var(--terracotta)}
        .save-button[aria-pressed=true] .icon {fill:var(--terracotta);stroke:var(--terracotta)}
        .package-body {padding:21px 22px 20px;display:flex;flex-direction:column;flex:1}
        .package-category {font-size:8px;font-weight:600;color:var(--terracotta);text-transform:uppercase;letter-spacing:1.8px;margin-bottom:8px}
        .package-title {font-family:var(--serif);font-size:25px;line-height:1.17;letter-spacing:-.3px}
        .package-title button {text-align:left;display:block}
        .package-title button:hover {color:var(--terracotta)}
        .package-teaser {font-size:11px;line-height:1.8;margin-top:10px;min-height:40px}
        .package-meta {display:flex;gap:15px;flex-wrap:wrap;color:#66705e;font-size:10px;margin-top:17px;padding-bottom:17px}
        .package-meta span {display:flex;align-items:center;gap:5px}
        .package-meta .icon {width:13px;height:13px}
        .package-bottom {border-top:1px solid #eeeee6;display:flex;align-items:center;justify-content:space-between;gap:10px;padding-top:15px;margin-top:auto}
        .package-price small {display:block;font-size:8px;color:#707668;line-height:1.5;margin-bottom:3px}
        .package-price strong {font-size:17px;line-height:1.3;font-weight:700;letter-spacing:-.4px}
        .package-price span {font-size:9px;font-weight:400;color:var(--muted);margin-left:3px}
        .details-button {display:flex;align-items:center;justify-content:center;gap:9px;font-size:10px;font-weight:600;background:var(--paper);border:1px solid #e7e6dd;padding:10px 13px;min-height:42px;border-radius:7px;transition:background .2s}
        .details-button:hover {background:var(--green);color:#fff;border-color:var(--green)}
        .details-button .icon {width:14px;height:14px}
        .custom-card {grid-column:span 2;background:var(--green);border:1px solid var(--green);border-radius:16px;color:#fff;padding:44px;position:relative;overflow:hidden;display:flex;align-items:center}
        .custom-card::after {content:'';position:absolute;width:310px;height:310px;border:1px solid #bac39d40;border-radius:50%;right:-120px;bottom:-160px;box-shadow:0 0 0 35px #bac39d0c,0 0 0 70px #bac39d0c,0 0 0 105px #bac39d08;pointer-events:none}
        .custom-card>div {position:relative;z-index:1;max-width:420px}
        .custom-card .eyebrow {color:#ddc19a;margin-bottom:18px;font-size:8px}
        .custom-card h3 {font-family:var(--serif);font-size:40px;line-height:1.12;letter-spacing:-.5px}
        .custom-card p {font-size:12px;line-height:1.8;color:#d1d9c9;margin:17px 0 22px;max-width:335px}
        .custom-card .button {background:#efe1ca;color:var(--ink);min-height:45px;font-size:11px}
        .custom-card-symbol {position:absolute;right:32px;top:34px;color:#d2b58a}
        .custom-card-symbol .icon {width:60px;height:60px;stroke-width:.9}
        .collection-note {font-size:10px;color:#697261;text-align:center;margin-top:25px;line-height:1.8}
        .empty-state {text-align:center;padding:60px 25px;border:1px dashed #c5cdbd;border-radius:15px;background:#ffffff55}
        .empty-state>.icon {width:34px;height:34px;color:var(--terracotta);margin-bottom:13px}
        .empty-state h3 {font:400 30px var(--serif)}
        .empty-state p {font-size:13px;margin:10px 0 20px}
        /* 06. Signature escape and planning steps */
        .signature {padding-block:95px}
        .signature-panel {display:grid;grid-template-columns:1.05fr 1fr;min-height:520px;overflow:hidden;border-radius:20px;background:var(--green);color:#fff}
        .signature-media {position:relative;min-height:440px;background:#614c36}
        .signature-media>img {position:absolute;width:100%;height:100%;object-fit:cover}
        .signature-media::after {content:'';position:absolute;inset:0;background:linear-gradient(0deg,#15211877,transparent 55%)}
        .signature-image-label {position:absolute;bottom:31px;left:30px;color:#fff5df;font:italic 30px/1.2 var(--serif);z-index:1}
        .signature-body {padding:55px 50px;display:flex;flex-direction:column;justify-content:center}
        .signature .eyebrow {color:#e2c398;font-size:9px;margin-bottom:20px}
        .signature h2 {font-size:47px;letter-spacing:-1px}
        .signature h2 em {color:#dfbe8a}
        .signature p {color:#d2dacb;font-size:13px;line-height:1.85;margin:22px 0}
        .signature-includes {display:flex;gap:17px;flex-wrap:wrap;margin:0 0 30px;color:#efe9da;font-size:10px}
        .signature-includes span {display:flex;gap:7px;align-items:center}
        .signature-includes .icon {width:16px;height:16px;color:#dac198}
        .signature-bottom {display:flex;justify-content:space-between;gap:20px;align-items:center;border-top:1px solid #ffffff2b;padding-top:26px}
        .signature-price small {display:block;font-size:9px;color:#d2dacb;margin-bottom:5px}
        .signature-price strong {font-size:23px;font-weight:600;letter-spacing:-.5px;line-height:1.3}
        .signature-price span {font-size:9px;color:#ced3c7;display:block}
        .signature-bottom .button {background:#edddc5;color:var(--ink);font-size:11px;min-height:46px;padding-inline:18px}
        .how {padding-top:0;padding-bottom:100px}
        .how-header {text-align:center;max-width:650px;margin:0 auto 45px}
        .how-header .eyebrow {justify-content:center}
        .how-header h2 {font-size:43px}
        .how-grid {display:grid;grid-template-columns:repeat(3,1fr);gap:58px;position:relative}
        .how-step {position:relative;padding-left:62px}
        .step-number {position:absolute;left:0;top:0;font-family:var(--serif);font-size:44px;line-height:1;color:#c2c8b7}
        .how-step h3 {font-size:14px;font-weight:600;line-height:1.5;margin-bottom:10px}
        .how-step p {font-size:12px;line-height:1.9}
        /* 07. Visual journal, gallery and guest stories */
        .gallery-section {padding-block:82px;background:var(--sand)}
        .gallery-header {display:flex;align-items:center;justify-content:space-between;gap:30px;margin-bottom:30px}
        .gallery-header h2 {font-size:45px}
        .gallery-header p {font-size:12px;margin-top:13px}
        .gallery-grid {display:grid;grid-template-columns:1.15fr .85fr 1.15fr .85fr;gap:17px;align-items:start}
        .gallery-item {width:100%;position:relative;overflow:hidden;border-radius:12px;aspect-ratio:.83;background:var(--sand-deep);text-align:left}
        .gallery-item:nth-child(even) {margin-top:35px;aspect-ratio:.88}
        .gallery-item img {width:100%;height:100%;object-fit:cover;transition:transform .7s}
        .gallery-item:hover img {transform:scale(1.06)}
        .gallery-item::after {content:'';position:absolute;inset:50% 0 0;background:linear-gradient(transparent,#1d271ab0);pointer-events:none}
        .gallery-item>span {position:absolute;bottom:20px;left:20px;right:20px;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:10px;color:#fff;font-size:11px}
        .gallery-item .icon {width:17px;height:17px}
        .stories {padding-block:100px}
        .stories-header {text-align:center;max-width:640px;margin:0 auto 39px}
        .stories-header .eyebrow {justify-content:center}
        .stories-header h2 {font-size:49px}
        .sample-label {display:inline-flex;gap:6px;align-items:center;margin-top:20px;border:1px solid var(--line);border-radius:5px;padding:4px 9px;font-size:9px;color:var(--muted);background:#fff}
        .sample-label .icon {width:12px;height:12px}
        .review-grid {display:grid;grid-template-columns:repeat(3,1fr);gap:23px}
        .review-card {border:1px solid var(--line);background:#fff;border-radius:14px;padding:28px;display:flex;flex-direction:column}
        .review-card>.icon {width:27px;height:27px;color:#ad6445;stroke-width:1.4;margin-bottom:16px}
        .review-card blockquote {font-family:var(--serif);font-size:22px;line-height:1.5;letter-spacing:-.15px;margin-bottom:27px;flex:1}
        .review-author {display:flex;align-items:center;gap:12px;border-top:1px solid #eceee5;padding-top:20px}
        .review-initials {display:grid;place-items:center;width:42px;height:42px;background:#e9e0d1;border-radius:50%;font-family:var(--serif);font-size:14px;flex-shrink:0}
        .review-initials.peach {background:#f5e4d8}
        .review-initials.olive {background:#e8eddd}
        .review-author strong {font-size:11px;font-weight:600;display:block;line-height:1.5}
        .review-author small {display:block;font-size:8px;color:#68745f;line-height:1.7;margin-top:3px}
        .review-note {font-size:9px;text-align:center;color:#6e7766;margin-top:23px}
        /* 08. FAQs and contact */
        .faq-section {padding-block:78px;border-top:1px solid var(--line);border-bottom:1px solid var(--line)}
        .faq-grid {display:grid;grid-template-columns:.8fr 1.2fr;gap:110px}
        .faq-intro h2 {font-size:44px}
        .faq-intro p {font-size:12px;line-height:1.9;margin:20px 0 18px}
        .faq-list details {border-bottom:1px solid var(--line)}
        .faq-list details:first-child {border-top:1px solid var(--line)}
        .faq-list summary {cursor:pointer;display:flex;justify-content:space-between;align-items:center;gap:24px;font-size:13px;font-weight:500;line-height:1.65;padding:20px 0;list-style:none}
        .faq-list summary::-webkit-details-marker {display:none}
        .faq-list summary .icon {width:16px;height:16px;color:#78816e;transition:transform .25s}
        .faq-list details[open] summary .icon {transform:rotate(45deg)}
        .faq-list details p {font-size:12px;line-height:1.95;padding:0 30px 23px 0}
        .contact-grid {display:grid;grid-template-columns:.9fr 1.1fr;gap:90px;align-items:start}
        .contact-copy h2 {font-size:53px;max-width:380px}
        .contact-copy>p {max-width:365px;font-size:13px;margin:24px 0 30px;line-height:1.9}
        .contact-detail {display:flex;align-items:center;gap:13px;margin-bottom:18px;font-size:12px}
        .contact-detail>.icon {width:19px;height:19px;color:var(--terracotta)}
        .contact-detail strong {font-weight:500;display:block;font-size:12px}
        .contact-detail small {display:block;font-size:10px;color:var(--muted);margin-top:2px}
        .contact-detail a:hover {text-decoration:underline}
        .contact-mini {position:relative;margin-top:29px;max-width:330px;aspect-ratio:2.25;overflow:hidden;border-radius:10px;background:var(--sand-deep)}
        .contact-mini img {width:100%;height:100%;object-fit:cover;object-position:center 65%}
        .contact-mini::after {content:'';position:absolute;inset:0;background:linear-gradient(transparent,#14231388)}
        .contact-mini span {position:absolute;bottom:15px;left:17px;z-index:1;font-family:var(--serif);font-style:italic;font-size:21px;color:#fff}
        .contact-form-card {background:#fff;padding:35px;border-radius:17px;border:1px solid var(--line);box-shadow:var(--shadow)}
        .form-heading {font-family:var(--serif);font-size:29px;line-height:1.3;margin-bottom:7px}
        .form-subtitle {font-size:11px;margin-bottom:25px}
        .form-grid {display:grid;grid-template-columns:1fr 1fr;gap:18px 16px}
        .field {min-width:0}
        .field.full {grid-column:1/-1}
        .field label {display:block;font-size:10px;font-weight:600;margin-bottom:7px;line-height:1.5}
        .field label .optional {font-weight:400;color:#6c7467;font-size:9px}
        .field input,.field select,.field textarea {display:block;width:100%;background:#fff;border:1px solid #dadfd1;border-radius:7px;padding:12px 13px;min-height:46px;font-size:13px;line-height:1.5;transition:border-color .2s,box-shadow .2s}
        .field textarea {min-height:102px}
        .field input::placeholder,.field textarea::placeholder {color:#8a8f82;opacity:1}
        .field input:focus,.field select:focus,.field textarea:focus {border-color:#9f7456;outline:0;box-shadow:0 0 0 3px #b8765420}
        .field input[aria-invalid=true],.field textarea[aria-invalid=true],.field select[aria-invalid=true] {border-color:#ad3434}
        .field-hint {display:block;font-size:9px;color:#697261;margin-top:6px;line-height:1.65}
        .check-field {display:flex;align-items:flex-start;gap:10px;font-size:10px;line-height:1.8;color:#646f5c;margin-block:18px;cursor:pointer}
        .check-field input {accent-color:var(--green);width:16px;height:16px;flex-shrink:0;margin:1px 0 0}
        .check-field a,.inline-button {text-decoration:underline;text-underline-offset:3px;color:var(--ink)}
        .form-submit {width:100%}
        .form-micro {font-size:9px;line-height:1.75;text-align:center;margin-top:11px}
        .form-preview {display:flex;align-items:flex-start;gap:8px;padding:10px 12px;background:#f5eedf;border:1px solid #ebe0c9;color:#716040;border-radius:6px;font-size:10px;line-height:1.7;margin-bottom:18px}
        .form-preview .icon {width:14px;height:14px;margin-top:2px}
        .form-error {border:1px solid #eccbcb;background:#fff2f0;padding:12px 14px;border-radius:7px;color:#912f2c;font-size:12px;margin-bottom:18px;line-height:1.8}
        .form-error ul {list-style:disc;padding-left:18px}
        .honeypot {position:absolute!important;left:-10000px;width:1px;height:1px;overflow:hidden}
        /* 09. End-of-page invitation and footer */
        .closing {position:relative;overflow:hidden;background:var(--terracotta);color:#fff4e4;text-align:center;padding:65px 20px}
        .closing::before,.closing::after {content:'';position:absolute;top:50%;width:400px;height:400px;border:1px solid #f6d8b42e;border-radius:50%;transform:translateY(-50%);box-shadow:0 0 0 30px #f6d8b40c,0 0 0 60px #f6d8b40a,0 0 0 90px #f6d8b409;pointer-events:none}
        .closing::before {left:-260px}
        .closing::after {right:-260px}
        .closing .icon {width:30px;height:30px;margin-bottom:17px;stroke-width:1.2}
        .closing h2 {font-size:clamp(38px,4.4vw,58px);letter-spacing:-1.2px}
        .closing p {font-size:12px;color:#f8e3d4;margin:16px 0 22px}
        .closing .button {color:var(--ink);background:#f8eddb;font-size:11px;min-height:46px}
        .closing .button .icon {width:16px;height:16px;margin:0}
        .site-footer {background:#243329;color:#e9ebdf;padding:62px 0 0}
        .footer-main {display:grid;grid-template-columns:1.7fr 1fr 1fr 1.05fr;gap:45px;padding-bottom:42px}
        .site-footer .brand-symbol {color:#d9b686}
        .site-footer .brand-name {font-size:24px}
        .footer-brand p {font-size:11px;line-height:1.9;max-width:240px;color:#b9c6b5;margin-top:23px}
        .footer-column h3 {font:600 11px var(--sans);color:#e4dcc7;margin:4px 0 19px}
        .footer-column a,.footer-column>span,.footer-column>button {display:block;color:#b9c6b5;font-size:10px;line-height:1.7;text-align:left;min-height:32px;padding-block:5px}
        .footer-column a:hover,.footer-column>button:hover {color:#fff}
        .footer-column .footer-note {font-size:9px;line-height:1.8;margin-top:7px;display:block;color:#aebbab}
        .footer-bottom {border-top:1px solid #52634f80;padding:20px 0;display:flex;justify-content:space-between;gap:20px;color:#bdc7b6;font-size:9px;align-items:center}
        .footer-bottom .text-link {font-size:9px;min-height:30px;color:#d1d8c9}
        .footer-bottom a:hover {color:#fff}
        .footer-preview {border-top:1px solid #52634f50;padding:12px 0 19px;color:#b6c1ae;font-size:8px;line-height:1.8}
        .mobile-bookbar {display:none}
        .toast {position:fixed;left:50%;bottom:27px;transform:translate(-50%,14px);z-index:200;background:var(--green);color:#fff;padding:13px 20px;border:1px solid #61705a;border-radius:9px;box-shadow:0 10px 30px #14271c26;font-size:12px;line-height:1.6;max-width:calc(100% - 36px);opacity:0;pointer-events:none;transition:opacity .2s,transform .2s}
        .toast.visible {opacity:1;transform:translate(-50%,0)}
        /* 10. Accessible native dialogs */
        dialog {color:var(--ink);background:var(--paper);border:0;padding:0;border-radius:18px;max-width:calc(100% - 40px);max-height:calc(100dvh - 48px);box-shadow:0 30px 110px #111c1950;overscroll-behavior:contain}
        dialog::backdrop {background:rgba(20,30,23,.66);backdrop-filter:blur(5px)}
        dialog:not([open]) {display:none}
        .dialog-close {position:absolute;top:16px;right:16px;z-index:5;box-shadow:0 3px 15px #21332410}
        .experience-dialog {width:1000px;overflow:hidden}
        .experience-layout {display:grid;grid-template-columns:.85fr 1.15fr;max-height:calc(100dvh - 48px)}
        .experience-image {position:relative;min-height:590px;background:#6e664d;overflow:hidden}
        .experience-image>img {position:absolute;width:100%;height:100%;object-fit:cover}
        .experience-image::after {content:'';position:absolute;inset:0;background:linear-gradient(0deg,#111e16bb,transparent 70%)}
        .experience-image-caption {position:absolute;bottom:30px;left:30px;right:30px;color:#fff;z-index:1}
        .experience-image-caption .eyebrow {color:#eed3b0;font-size:9px}
        .experience-image-caption strong {font:italic 36px/1.15 var(--serif);display:block;margin-bottom:13px}
        .experience-image-caption small {font-size:10px;display:flex;gap:6px;align-items:center}
        .experience-image-caption small .icon {width:13px;height:13px}
        .experience-content {display:flex;flex-direction:column;min-width:0;max-height:calc(100dvh - 48px)}
        .experience-scroll {padding:39px 34px 20px;overflow-y:auto;overscroll-behavior:contain;flex:1;min-height:0}
        .experience-heading {padding-right:36px}
        .experience-heading .eyebrow {font-size:8px;margin-bottom:14px}
        .experience-heading h2 {font-size:38px;letter-spacing:-.6px;outline:none}
        .detail-meta {display:flex;flex-wrap:wrap;gap:9px 16px;margin:17px 0 24px;font-size:10px;color:var(--muted)}
        .detail-meta span {display:flex;align-items:center;gap:6px}
        .detail-meta .icon {width:14px;height:14px}
        .detail-tabs {display:flex;border-bottom:1px solid var(--line);gap:19px;margin-bottom:20px}
        .detail-tab {padding:11px 0;font-size:11px;min-height:44px;border-bottom:2px solid transparent;color:var(--muted)}
        .detail-tab[aria-selected=true] {color:var(--terracotta);border-color:var(--terracotta);font-weight:600}
        .detail-panel p {font-size:12px;line-height:1.9}
        .detail-panel h3 {font-size:12px;font-weight:600;margin:20px 0 13px}
        .included-list {display:grid;grid-template-columns:1fr 1fr;gap:10px 12px}
        .included-list li {display:flex;align-items:flex-start;gap:8px;font-size:10px;line-height:1.7}
        .included-list .icon {width:14px;height:14px;color:#647c4b;margin-top:2px}
        .itinerary-list {counter-reset:itinerary}
        .itinerary-list li {position:relative;counter-increment:itinerary;padding:0 0 24px 42px}
        .itinerary-list li::before {content:counter(itinerary,decimal-leading-zero);position:absolute;left:0;top:1px;font:400 21px var(--serif);color:var(--terracotta)}
        .itinerary-list li:not(:last-child)::after {content:'';position:absolute;left:11px;top:30px;bottom:5px;border-left:1px solid var(--line)}
        .itinerary-list strong {font-size:12px;font-weight:600;display:block;margin-bottom:4px}
        .itinerary-list p {font-size:11px;line-height:1.8}
        .detail-notes li {font-size:11px;color:var(--muted);padding:12px 0;border-bottom:1px solid var(--line);line-height:1.8}
        .experience-footer {flex-shrink:0;border-top:1px solid var(--line);padding:19px 34px;background:#fff;display:flex;align-items:center;gap:16px;justify-content:space-between}
        .detail-price small {font-size:9px;display:block;color:var(--muted)}
        .detail-price strong {font-size:24px;letter-spacing:-.6px;display:block;line-height:1.3}
        .experience-footer .button {font-size:11px;padding-inline:17px;min-height:48px;gap:10px}
        .booking-dialog {width:870px;overflow-y:auto}
        .booking-header {padding:30px 35px 23px;border-bottom:1px solid var(--line);padding-right:76px}
        .booking-header .eyebrow {margin-bottom:11px;font-size:8px}
        .booking-header h2 {font-size:36px;letter-spacing:-.6px;outline:0}
        .booking-header p {font-size:11px;margin-top:9px}
        .booking-layout {display:grid;grid-template-columns:1fr 250px;gap:27px;padding:28px 35px 32px;align-items:start}
        .booking-layout .form-grid {gap:16px 14px}
        .booking-aside {background:#f0ede3;border:1px solid #e1e4d4;border-radius:11px;overflow:hidden;position:sticky;top:18px}
        .booking-aside>img {height:138px;width:100%;object-fit:cover;background:var(--sand-deep)}
        .booking-aside-body {padding:18px}
        .booking-aside small {font-size:8px;text-transform:uppercase;letter-spacing:1.3px;color:var(--terracotta);display:block;margin-bottom:8px}
        .booking-aside h3 {font:400 24px/1.2 var(--serif);margin-bottom:17px}
        .booking-summary-line {display:flex;justify-content:space-between;gap:12px;font-size:10px;padding:8px 0;color:var(--muted)}
        .booking-summary-line strong {color:var(--ink);font-weight:500;text-align:right}
        .booking-total {border-top:1px solid #d5dbcc;margin-top:10px;padding-top:14px;font-size:11px;display:flex;gap:12px;justify-content:space-between;align-items:center}
        .booking-total strong {font-size:19px;white-space:nowrap;letter-spacing:-.4px}
        .booking-aside p {font-size:9px;line-height:1.8;margin-top:12px}
        .stepper {display:flex;align-items:center;border:1px solid #dadfd1;border-radius:7px;background:#fff;min-height:46px;overflow:hidden}
        .stepper button {width:41px;min-height:44px;display:grid;place-items:center;flex-shrink:0}
        .stepper button:hover {background:var(--sand)}
        .stepper button .icon {width:15px;height:15px}
        .stepper input {border:0;box-shadow:none!important;border-radius:0;padding-inline:0;min-height:44px;text-align:center;appearance:textfield;-moz-appearance:textfield}
        .stepper input::-webkit-inner-spin-button,.stepper input::-webkit-outer-spin-button {-webkit-appearance:none;margin:0}
        .success-dialog {width:530px;padding:42px;text-align:center}
        .success-icon {display:grid;place-items:center;width:70px;height:70px;background:#e6ecdf;border-radius:50%;margin:0 auto 20px;color:var(--green)}
        .success-icon .icon {width:29px;height:29px;stroke-width:1.8}
        .success-dialog .eyebrow {justify-content:center;margin-bottom:12px;font-size:8px}
        .success-dialog h2 {font-size:40px;letter-spacing:-.7px;outline:0}
        .success-dialog>p {font-size:12px;line-height:1.9;margin-top:16px}
        .success-summary {border:1px solid var(--line);background:#fff;border-radius:10px;padding:17px 19px;margin-block:24px;text-align:left}
        .success-summary div {display:flex;justify-content:space-between;gap:17px;padding:7px 0;font-size:11px;line-height:1.7}
        .success-summary dt {color:var(--muted)}
        .success-summary dd {margin:0;font-weight:500;text-align:right;overflow-wrap:anywhere;max-width:65%}
        .success-dialog .button {width:100%;font-size:12px;margin-top:20px}
        .success-warning {font-size:10px!important;padding:12px 15px;background:#f4eddd;border-radius:8px;border:1px solid #e9dec9;color:#736042!important}
        .info-dialog {width:570px;padding:40px}
        .info-dialog h2 {font-size:37px;padding-right:35px;margin-bottom:20px;outline:0}
        .info-dialog p {font-size:12px;line-height:1.9;margin:15px 0}
        .info-dialog .button {margin-top:15px}
        .lightbox-dialog {width:1000px;background:#1c291f;color:#fff;overflow:hidden}
        .lightbox-dialog img {width:100%;height:min(68dvh,650px);object-fit:contain;background:#17221b}
        .lightbox-caption {padding:19px 25px;display:flex;justify-content:space-between;gap:20px;align-items:center}
        .lightbox-caption h2 {font:400 27px var(--serif);letter-spacing:0;outline:0}
        .lightbox-caption p {font-size:10px;color:#c4cebb}
        .lightbox-caption a {text-decoration:underline;text-underline-offset:3px}
        .button.is-loading .icon {display:none}
        .button.is-loading::after {content:'';width:16px;height:16px;border:2px solid #ffffff55;border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite}
        @keyframes spin {to{transform:rotate(360deg)}}
        /* 11. Responsive layouts: no horizontal tables, sliders, or cramped form fields */
        @media(min-width:1650px) {.hero-inner{min-height:745px}.hero h1{font-size:98px}}
        @media(max-width:1150px) {
            .nav-links{gap:20px}.nav-actions .button{padding-inline:14px}
            .hero-inner{grid-template-columns:1fr 255px;gap:28px;min-height:650px;padding-top:85px}.hero h1{font-size:76px}
            .hero-postcard{width:255px}.hero-postcard img{width:61px}.hero-postcard strong{font-size:21px}
            .finder-field{padding-inline:15px;gap:10px}.finder .button{padding-inline:20px;margin-left:12px}
            .about-grid{gap:55px}.about-photos{height:505px}.about-main{height:440px}.about-secondary{height:255px}
            .package-body{padding:20px 18px}.package-title{font-size:24px}.packages-grid{gap:20px}.package-meta{gap:12px}
            .signature-body{padding:42px 33px}.signature h2{font-size:42px}.signature-bottom{gap:12px}.signature-bottom .button{padding-inline:14px;gap:9px}
            .faq-grid{gap:70px}.contact-grid{gap:50px}.review-card{padding:23px}.review-card blockquote{font-size:21px}
            .footer-main{gap:30px}.custom-card{padding:34px}.custom-card h3{font-size:38px}
        }
        @media(max-width:950px) {
            :root{--header-height:78px}.nav-links{display:none}.menu-toggle{display:inline-flex}.nav-actions .button{min-height:42px}
            .mobile-menu{position:absolute;top:100%;left:0;right:0;display:block;background:var(--paper);border-bottom:1px solid var(--line);padding:14px 32px 25px;box-shadow:0 15px 25px #24332112;max-height:calc(100dvh - 85px);overflow-y:auto}
            .mobile-menu a{display:flex;align-items:center;justify-content:space-between;min-height:50px;border-bottom:1px solid var(--line);font-size:14px}.mobile-menu a .icon{width:16px;height:16px}
            .hero-inner{grid-template-columns:1fr 200px;min-height:610px;gap:18px}.hero h1{font-size:65px;letter-spacing:-2px}.hero-copy>p{font-size:13px;max-width:345px}
            .hero-postcard{width:203px;padding:12px;gap:10px}.hero-postcard img{display:none}.hero-postcard strong{font-size:23px}.hero-postcard small{font-size:8px}
            .hero-seal{width:100px;height:100px}.hero-seal .icon{width:27px;height:27px}.hero-seal span{font-size:8px}
            .finder{grid-template-columns:1fr 1fr;padding:15px;gap:15px 0}.finder-field{border-right:0}.finder-field:nth-child(odd){border-right:1px solid var(--line)}.finder .button{margin-left:15px;min-height:48px}
            .about-grid{gap:40px}.about-photos{height:460px;margin-right:0}.about-main{height:395px;width:81%}.about-secondary{height:230px;width:52%}.about-stamp{height:81px;width:81px;right:-10px;top:28px}.about-stamp .icon{width:35px;height:35px}
            .about-copy h2{font-size:42px}.about-points{gap:12px;grid-template-columns:1fr}.about-point{font-size:11px}.about-copy .section-intro{font-size:12px}.about-signature>span{font-size:19px}.about-signature .text-link{font-size:11px;gap:7px}
            .section{padding-block:80px}.packages-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:22px}.package-title{font-size:27px}.package-teaser{font-size:12px}.package-body{padding:22px}.custom-card{grid-column:1/-1;min-height:300px;padding:40px}
            .custom-card>div{max-width:600px}.custom-card p{max-width:420px}.custom-card-symbol{right:65px;top:48px}.custom-card-symbol .icon{width:86px;height:86px}
            .signature-panel{grid-template-columns:1fr 1fr}.signature-body{padding:35px 28px}.signature h2{font-size:38px}.signature p{font-size:12px}.signature-bottom{align-items:flex-start;flex-direction:column}.signature-price span{display:inline;margin-left:5px}.signature-bottom .button{width:100%}
            .how-grid{gap:30px}.how-step{padding-left:45px}.step-number{font-size:34px}.how-step h3{font-size:12px}.how-step p{font-size:11px}
            .gallery-grid{gap:13px}.gallery-header h2{font-size:40px}.gallery-item>span{left:13px;right:13px;font-size:10px;bottom:15px}
            .review-grid{gap:15px}.review-card{padding:21px}.review-card blockquote{font-size:20px}.review-author{gap:9px}.review-initials{width:34px;height:34px;font-size:12px}
            .faq-grid{gap:45px;grid-template-columns:.8fr 1.2fr}.faq-intro h2{font-size:37px}.faq-list summary{font-size:12px}
            .contact-grid{gap:35px;grid-template-columns:.85fr 1.15fr}.contact-copy h2{font-size:43px}.contact-form-card{padding:25px}.form-grid{gap:17px 12px}
            .footer-main{grid-template-columns:1.5fr 1fr 1fr;gap:35px}.footer-column:last-child{grid-column:2/-1;display:flex;gap:24px;flex-wrap:wrap;align-items:center}.footer-column:last-child h3{margin:0}.footer-column:last-child .footer-note{max-width:260px;margin:0}
            .experience-layout{grid-template-columns:.75fr 1.25fr}.experience-scroll{padding:35px 27px 20px}.experience-heading h2{font-size:34px}.experience-footer{padding:18px 27px}.experience-footer .button{font-size:10px}.detail-price strong{font-size:22px}
        }
        @media(max-width:700px) {
            :root{--header-height:73px;--page-gutter:20px}html{scroll-padding-top:90px}.section{padding-block:65px}
            .preview-strip{font-size:9px;padding:5px 16px}.nav-bar{gap:12px}.brand-symbol{width:35px;height:35px}.brand{gap:8px}.brand-name{font-size:20px;letter-spacing:2.7px}.brand-tagline{font-size:6.6px;letter-spacing:1.9px;margin-top:3px}
            .nav-actions{gap:9px}.nav-actions .button{font-size:10px;min-height:40px;padding:10px 12px;gap:8px}.nav-actions .button .icon{width:14px;height:14px}.menu-toggle{width:39px;height:39px}.mobile-menu{padding-inline:20px}
            .hero{width:100%;border-radius:0}.hero-inner{display:block;padding:66px 0 94px;min-height:595px}.hero h1{font-size:clamp(51px,9.3vw,67px);letter-spacing:-1.8px;max-width:540px}
            .hero-photo{object-position:57% 50%}.hero::before{background:linear-gradient(90deg,#1723179e,#1c281d40),linear-gradient(0deg,#20291d77,transparent 80%)}
            .hero .eyebrow{font-size:8px;letter-spacing:1.8px;margin-bottom:25px}.hero-copy>p{font-size:13px;max-width:310px;line-height:1.8;margin-top:23px}
            .hero-actions{gap:19px;margin-top:28px}.hero-actions .button{font-size:12px;min-height:48px;padding-inline:18px;gap:11px}.hero-actions .text-link{font-size:11px}
            .hero-side{display:none}.hero-caption{bottom:57px;right:var(--page-gutter);font-size:8px}.hero-caption .icon{width:11px;height:11px}.finder-wrap{margin-top:-27px}
            .finder{padding:14px 10px;gap:15px 0;border-radius:13px}.finder-field{padding-inline:12px;gap:9px}.finder-field>.icon{width:18px;height:18px}.finder label{font-size:8px;letter-spacing:1px}.finder input,.finder select{font-size:16px;line-height:1.4;min-height:30px;padding:4px 0 1px;width:100%}.finder .button{margin-inline:12px;font-size:11px;gap:10px;min-height:48px;padding-inline:11px}
            .benefit-strip{padding:26px 0;gap:13px}.benefit{flex-direction:column;align-items:flex-start;gap:8px;padding:0 8px}.benefit:first-child{padding-left:0}.benefit:last-child{padding-right:0}.benefit .icon{width:21px;height:21px}.benefit strong{font-size:10px;line-height:1.55}.benefit span{font-size:9px;line-height:1.5;margin-top:3px}
            .about-grid{grid-template-columns:1fr;gap:43px}.about-photos{height:440px;max-width:440px;width:100%;margin:auto}.about-main{height:391px;width:75%}.about-secondary{height:240px;width:46%}.about-stamp{right:4px;top:28px;width:84px;height:84px}.about-caption{font-size:20px;bottom:0}
            .about-copy h2{font-size:46px;max-width:430px}.eyebrow{font-size:9px;margin-bottom:16px}.about-copy .section-intro{font-size:14px;max-width:none}.about-points{grid-template-columns:1fr 1fr;gap:18px;margin-block:25px}.about-point{font-size:12px}.about-signature>span{font-size:23px}.about-signature .text-link{font-size:12px}
            .section-heading{display:block;margin-bottom:26px}.section-heading h2{font-size:45px}.section-heading>p{font-size:13px;max-width:380px;margin-top:19px;padding:0}.filter-row{gap:10px;padding-bottom:18px}.filter-chips{gap:7px}.filter-chip{font-size:10px;min-height:40px;padding:9px 13px}.filter-saved{padding-left:0;min-height:33px}
            .collection-search-row{flex-wrap:wrap;gap:10px;margin-top:14px}.collection-search{width:100%;border-bottom:1px solid #dcded0;padding-bottom:9px}.collection-search input{font-size:16px;padding-block:7px}.collection-tools{width:100%;justify-content:space-between}.result-count{font-size:10px}.sort-select{font-size:16px;max-width:172px;min-height:42px}.collection-toolbar{margin-bottom:18px}
            .packages-grid{gap:18px}.package-media{aspect-ratio:1.25}.package-body{padding:17px 14px}.package-title{font-size:22px}.package-category{font-size:7px;letter-spacing:1.3px}.package-teaser{font-size:10px;margin-top:9px;min-height:54px}.package-meta{gap:5px;flex-direction:column;font-size:9px;margin-top:13px;padding-bottom:13px}.package-tag{font-size:7px;padding:5px 7px;top:11px;left:11px}.save-button{height:33px;width:33px;top:9px;right:9px}.save-button .icon{width:14px;height:14px}.package-bottom{flex-wrap:wrap;gap:12px;padding-top:13px}.package-price strong{font-size:17px}.package-price span{font-size:8px}.details-button{width:100%;justify-content:space-between;font-size:10px;min-height:39px}
            .custom-card{min-height:300px;padding:30px}.custom-card h3{font-size:37px;max-width:300px}.custom-card p{font-size:12px;max-width:270px}.custom-card-symbol{right:24px;top:26px;opacity:.5}.custom-card-symbol .icon{width:46px;height:46px}.collection-note{font-size:9px;padding-inline:10px;margin-top:23px}
            .signature{padding-block:65px}.signature-panel{grid-template-columns:1fr;border-radius:15px}.signature-media{min-height:340px}.signature-body{padding:34px 28px}.signature h2{font-size:43px}.signature p{font-size:13px}.signature-includes{font-size:10px;gap:17px}.signature-bottom{flex-direction:row;align-items:center;gap:18px}.signature-bottom .button{width:auto;min-height:47px}.signature-price strong{font-size:24px}.signature-price span{display:block;margin:2px 0 0}
            .how{padding:0 0 65px}.how-header{text-align:left;margin-bottom:30px}.how-header .eyebrow{justify-content:flex-start}.how-header h2{font-size:38px}.how-grid{grid-template-columns:1fr;gap:26px}.how-step{padding-left:65px;max-width:430px}.step-number{font-size:43px}.how-step h3{font-size:14px;margin-bottom:7px}.how-step p{font-size:12px}
            .gallery-section{padding-block:62px}.gallery-header{align-items:flex-start;margin-bottom:25px}.gallery-header h2{font-size:38px}.gallery-header p{font-size:11px;max-width:270px}.gallery-header>.text-link{font-size:10px;gap:7px;white-space:nowrap;padding-top:3px}.gallery-grid{grid-template-columns:1fr 1fr;gap:14px}.gallery-item{aspect-ratio:.86}.gallery-item:nth-child(even){margin-top:25px;aspect-ratio:.86}.gallery-item:nth-child(3){margin-top:-25px}.gallery-item>span{font-size:11px}
            .stories{padding-block:66px}.stories-header h2{font-size:42px}.stories-header{margin-bottom:28px}.review-grid{grid-template-columns:1fr;gap:17px}.review-card{padding:26px}.review-card blockquote{font-size:24px;margin-bottom:22px}.review-author strong{font-size:12px}.review-author small{font-size:10px}.review-initials{width:42px;height:42px;font-size:14px}.review-note{font-size:9px;margin-top:18px}
            .faq-section{padding-block:62px}.faq-grid{grid-template-columns:1fr;gap:26px}.faq-intro h2{font-size:41px}.faq-intro p{max-width:370px;font-size:13px;margin-bottom:8px}.faq-list summary{font-size:13px;padding-block:19px}.faq-list details p{font-size:12px;padding-right:15px}
            .contact-grid{grid-template-columns:1fr;gap:32px}.contact-copy h2{font-size:47px;max-width:400px}.contact-copy>p{font-size:13px;max-width:400px}.contact-mini{display:none}.contact-detail{margin-bottom:14px}.contact-form-card{padding:27px 23px}.form-heading{font-size:29px}.form-subtitle{font-size:11px}.field label{font-size:11px}.field input,.field select,.field textarea{font-size:16px;padding:12px;min-height:48px}.field textarea{min-height:118px}.field-hint{font-size:10px}.check-field{font-size:11px}.form-grid{gap:18px 13px}.form-preview{font-size:10px}.form-micro{font-size:10px}
            .closing{padding:53px 22px}.closing h2{font-size:42px}.closing p{font-size:12px;max-width:300px;margin-inline:auto}.closing::before{left:-310px}.closing::after{right:-310px}
            .site-footer{padding-top:45px;padding-bottom:80px}.footer-main{grid-template-columns:1fr 1fr;gap:30px}.footer-brand{grid-column:1/-1}.footer-brand p{max-width:330px;font-size:12px;margin-top:17px}.footer-column h3{font-size:12px;margin-bottom:14px}.footer-column a,.footer-column>button,.footer-column>span{font-size:11px;min-height:37px}.footer-column:last-child{grid-column:1/-1;display:block}.footer-column:last-child h3{margin-bottom:12px}.footer-column:last-child .footer-note{max-width:330px;font-size:10px;margin-top:5px}.footer-bottom{align-items:flex-start;flex-wrap:wrap;padding-block:19px;gap:7px;font-size:10px}.footer-preview{font-size:9px}
            .mobile-bookbar{display:flex;justify-content:space-between;align-items:center;gap:14px;position:fixed;bottom:0;left:0;right:0;z-index:25;padding:10px 20px calc(10px + env(safe-area-inset-bottom));background:rgba(250,248,243,.97);border-top:1px solid var(--line);backdrop-filter:blur(12px);box-shadow:0 -5px 25px #23302308;transform:translateY(120%);visibility:hidden;transition:transform .25s,visibility .25s}
            .mobile-bookbar.visible{transform:translateY(0);visibility:visible}.mobile-bookbar strong{display:block;font:400 19px/1.2 var(--serif)}.mobile-bookbar small{display:block;font-size:9px;color:var(--muted);margin-top:4px}.mobile-bookbar .button{font-size:11px;min-height:44px;padding:11px 17px;gap:12px}.toast{bottom:90px;font-size:11px;width:max-content}
            dialog{max-width:calc(100% - 24px);max-height:calc(100dvh - 24px);border-radius:15px}.experience-dialog{width:560px;overflow-y:auto}.experience-layout{display:block;max-height:none}.experience-image{min-height:225px;height:225px}.experience-image-caption{left:22px;bottom:20px}.experience-image-caption .eyebrow{margin-bottom:9px;font-size:8px}.experience-image-caption strong{font-size:28px;margin-bottom:9px}.experience-image-caption small{font-size:9px}.experience-content{max-height:none}.experience-scroll{padding:25px 23px 22px;overflow:visible}.experience-heading{padding-right:0}.experience-heading h2{font-size:35px}.experience-heading .eyebrow{font-size:8px}.detail-tabs{gap:23px}.detail-tab{font-size:12px}.detail-meta{font-size:10px;gap:12px;margin-block:17px}.detail-panel p{font-size:12px}.included-list li{font-size:11px}.experience-footer{position:sticky;bottom:0;padding:15px 23px calc(15px + env(safe-area-inset-bottom));z-index:2;gap:16px}.experience-footer .button{font-size:11px;padding:12px 17px}.detail-price strong{font-size:23px}.dialog-close{right:12px;top:12px;width:40px;height:40px}
            .booking-header{padding:27px 24px 20px;padding-right:64px}.booking-header h2{font-size:32px}.booking-header p{font-size:11px}.booking-layout{display:flex;flex-direction:column-reverse;gap:22px;padding:22px 23px 28px}.booking-layout form{width:100%}.booking-aside{position:static;width:100%;display:grid;grid-template-columns:95px 1fr;align-items:stretch}.booking-aside>img{height:100%;min-height:156px;object-fit:cover}.booking-aside-body{padding:15px}.booking-aside h3{font-size:23px;margin-bottom:8px}.booking-aside small{font-size:7px;margin-bottom:5px}.booking-summary-line{padding-block:3px;font-size:9px}.booking-total{font-size:10px;margin-top:8px;padding-top:10px}.booking-total strong{font-size:18px}.booking-aside p{font-size:8px;margin-top:8px}.booking-aside .optional-summary{display:none}.stepper input{font-size:16px}.stepper button{min-height:47px}
            .success-dialog{padding:35px 25px}.success-dialog h2{font-size:36px}.success-dialog>p{font-size:12px}.success-summary{padding:13px 15px}.success-summary div{font-size:11px}.info-dialog{padding:31px 25px}.info-dialog h2{font-size:33px}.lightbox-caption{display:block;padding:19px 20px}.lightbox-caption h2{font-size:25px}.lightbox-caption p{margin-top:8px}.lightbox-dialog img{height:auto;max-height:68dvh;min-height:180px;object-fit:contain}
        }
        @media(max-width:480px) {
            .packages-grid{grid-template-columns:1fr}.package-media{aspect-ratio:1.48}.package-body{padding:22px}.package-title{font-size:29px}.package-category{font-size:8px;letter-spacing:1.6px}.package-teaser{font-size:12px;min-height:0;margin-top:11px}.package-meta{flex-direction:row;gap:16px;font-size:10px;margin-top:18px;padding-bottom:17px}.package-meta .icon{width:14px;height:14px}.package-bottom{flex-wrap:nowrap;padding-top:16px}.package-price strong{font-size:20px}.package-price small{font-size:9px}.package-price span{font-size:9px}.details-button{width:auto;min-height:43px;padding-inline:16px;font-size:11px;gap:14px}.package-tag{font-size:8px;left:15px;top:15px;padding:6px 10px}.save-button{width:39px;height:39px;top:12px;right:12px}.save-button .icon{width:17px;height:17px}
            .hero-inner{min-height:560px;padding-top:52px;padding-bottom:95px}.hero h1{font-size:clamp(44px,12.6vw,60px);letter-spacing:-1.5px}.hero-copy>p{font-size:12px;max-width:285px}.hero .eyebrow{font-size:7.8px;gap:8px;letter-spacing:1.4px;margin-bottom:22px}.hero .eyebrow::before{width:20px}.hero-actions{gap:15px}.hero-actions .button{padding-inline:16px;font-size:11px;gap:10px}.hero-actions .text-link{font-size:10px;gap:8px}
            .finder-field{padding-inline:9px;gap:7px}.finder-field>.icon{width:16px;height:16px}.finder .button{margin-inline:9px;padding-inline:9px;font-size:10px;gap:7px}.finder .button .icon{width:14px;height:14px}.finder label{font-size:7px;letter-spacing:.8px}
            .about-photos{height:374px}.about-main{height:332px;width:77%}.about-secondary{height:210px;width:48%}.about-stamp{right:0;top:23px;height:74px;width:74px}.about-caption{font-size:18px;width:115px}.about-copy h2{font-size:42px}.about-point{font-size:11px;gap:8px}.about-signature{gap:8px}.about-signature>span{font-size:21px}.about-signature .text-link{font-size:11px;gap:9px}
            .section-heading h2{font-size:41px}.custom-card{padding:29px;min-height:317px}.custom-card h3{font-size:37px}.custom-card-symbol{right:20px;top:24px}.custom-card .eyebrow{max-width:200px;font-size:7px}.signature-media{min-height:290px}.signature-body{padding:30px 24px}.signature h2{font-size:40px}.signature-bottom{gap:12px}.signature-bottom .button{font-size:10px;padding-inline:13px;gap:8px}.signature-price strong{font-size:22px}.signature-price small{font-size:8px}.signature-includes{gap:13px;font-size:9px}.signature-includes .icon{width:15px;height:15px}
            .gallery-header{display:block}.gallery-header>.text-link{margin-top:8px}.gallery-header h2{font-size:37px}.gallery-item>span{left:12px;right:12px;font-size:10px;gap:5px}.gallery-item .icon{width:14px;height:14px}.gallery-grid{gap:12px}.gallery-item:nth-child(even){margin-top:22px}.gallery-item:nth-child(3){margin-top:-22px}
            .contact-form-card{padding:26px 20px}.contact-form-card .form-grid{grid-template-columns:1fr}.form-heading{font-size:28px}.contact-copy h2{font-size:44px}.check-field{font-size:10px}.contact-form-card .button{font-size:12px}.closing h2{font-size:39px}
            .experience-scroll{padding:23px 20px}.experience-heading h2{font-size:33px}.experience-image{height:200px;min-height:200px}.experience-footer{padding:14px 18px calc(14px + env(safe-area-inset-bottom));gap:12px}.experience-footer .button{font-size:10px;padding-inline:12px;gap:7px;max-width:62%}.detail-price strong{font-size:22px}.detail-price small{font-size:8px}.detail-tabs{gap:20px}.detail-tab{font-size:11px}.included-list{gap:9px 10px}.included-list li{font-size:10px}
            .booking-layout{padding:20px;gap:20px}.booking-layout .form-grid{grid-template-columns:1fr}.booking-layout .field.half-mobile{grid-column:auto}.booking-header{padding-left:20px}.booking-header h2{font-size:30px}.booking-aside{grid-template-columns:83px 1fr}.booking-aside-body{padding:13px}.booking-aside h3{font-size:21px}.booking-aside>img{min-height:165px}.booking-summary-line{font-size:9px}.booking-total{font-size:9px;gap:8px}.booking-total strong{font-size:17px}
        }
        @media(max-width:360px) {
            :root{--page-gutter:16px}.nav-actions>.button{display:none}.hero h1{font-size:43px}.hero-inner{padding-inline:0;min-height:545px}.hero-actions{gap:12px}.hero-actions .button{font-size:10px;padding-inline:14px}.hero-actions .text-link{font-size:9px}.finder-field>.icon{display:none}.finder .button{font-size:9px}.brand-name{font-size:19px}.about-photos{height:337px}.about-main{height:300px}.about-secondary{height:188px}.about-copy h2{font-size:38px}.about-signature>span{font-size:19px}.about-signature .text-link{font-size:10px}.signature-bottom{align-items:stretch;flex-direction:column}.signature-bottom .button{width:100%}.custom-card h3{font-size:33px}.custom-card-symbol{opacity:.25}.contact-form-card{padding-inline:17px}.gallery-header h2{font-size:34px}.filter-chip{font-size:9px;padding-inline:11px}.gallery-item>span{font-size:9px}.mobile-bookbar{padding-inline:16px}.mobile-bookbar strong{font-size:17px}.mobile-bookbar .button{font-size:10px;padding-inline:13px}
        }

        /* 12. Desert sketchbook. These are lightweight, reusable inline SVGs.
           The illustration plane is explicitly behind the content plane, never over
           buttons or form controls. Each section clips its own decorative overflow. */
        :root {
            color-scheme:light;
            --header-bg:rgba(250,248,243,.96);
            --decor-ink:#a97045; --decor-olive:#768365; --decor-opacity:.48;
            --profile-bg:#f0eadd; --profile-ring:#faf8f3;
        }
        html {background:var(--paper)}
        .button.is-loading::after {border-color:currentColor;border-right-color:transparent}
        .site-header {background:var(--header-bg)}
        .decorated-section {position:relative;isolation:isolate}
        .decorated-section>.container,.hero-inner {position:relative;z-index:1}
        .ambient-decor {position:absolute;inset:0;z-index:0;overflow:hidden;pointer-events:none;user-select:none;-webkit-user-select:none;contain:paint}
        .decor-mark {position:absolute;display:block;width:112px;height:112px;fill:none;color:var(--decor-ink);opacity:var(--decor-opacity);pointer-events:none}
        .decor-mark--dots {width:105px;height:72px;color:var(--decor-olive);opacity:.48}
        .decor-mark--dunes {width:260px;height:117px;opacity:.29}
        .decor-mark--arch {width:170px;height:227px;opacity:.26}
        .decor-mark--sparkles {width:78px;height:78px;opacity:.48}
        .decor-mark--trail {width:200px;height:77px;opacity:.37}
        .decor-mark--desert {width:500px;height:148px;opacity:.28}
        .decor-mark--palm {width:130px;height:182px;opacity:.25}
        .ambient-decor--hero {--decor-ink:#fff0cc;--decor-olive:#fff0cc}
        .ambient-decor--hero .decor-slot-a {left:61%;top:15%;width:104px;height:104px;opacity:.62}
        .ambient-decor--hero .decor-slot-b {right:23%;bottom:17%;width:250px;height:96px;opacity:.42;transform:rotate(-14deg)}
        .ambient-decor--hero .decor-slot-c {left:43%;bottom:3%;width:320px;height:144px;opacity:.22}
        .ambient-decor--about .decor-slot-a {right:-26px;top:20px;width:186px;height:186px}
        .ambient-decor--about .decor-slot-b {left:48%;top:23%;width:82px}
        .ambient-decor--about .decor-slot-c {left:-60px;bottom:36px;width:235px;height:314px}
        .ambient-decor--about .decor-slot-d {right:12%;bottom:-7px;width:310px;height:140px}
        .ambient-decor--about .decor-slot-e {left:48%;bottom:58px;width:58px;height:58px}
        .ambient-decor--collection .decor-slot-a {left:54%;top:55px;width:190px;height:190px;opacity:.57}
        .ambient-decor--collection .decor-slot-b {left:calc(var(--page-gutter) + 250px);top:27px;width:100px}
        .ambient-decor--collection .decor-slot-c {right:-110px;top:8px;width:600px;height:178px;opacity:.20}
        .ambient-decor--collection .decor-slot-d {left:-72px;top:44%;width:210px;height:280px}
        .ambient-decor--collection .decor-slot-e {right:2px;top:66%;width:90px;opacity:.34}
        .ambient-decor--collection .decor-slot-f {right:28%;top:35px;width:57px;height:57px}
        .ambient-decor--collection .decor-slot-g {right:-55px;bottom:0;width:420px;height:145px}
        .ambient-decor--signature .decor-slot-a {left:12%;top:15px}
        .ambient-decor--signature .decor-slot-b {right:-32px;bottom:0;width:125px;height:125px}
        .ambient-decor--signature .decor-slot-c {left:-52px;top:10px;width:135px;height:180px}
        .ambient-decor--signature .decor-slot-d {right:43%;bottom:12px;width:66px;height:66px}
        .ambient-decor--signature .decor-slot-e {right:18%;top:13px}
        .ambient-decor--steps .decor-slot-a {left:7%;top:0;width:128px;height:128px}
        .ambient-decor--steps .decor-slot-b {left:20%;bottom:7px;width:84px}
        .ambient-decor--steps .decor-slot-c {right:8%;top:-15px;width:112px;height:149px}
        .ambient-decor--steps .decor-slot-d {right:3%;bottom:-8px}
        .ambient-decor--steps .decor-slot-e {right:25%;top:7px;width:43px;height:43px}
        .ambient-decor--gallery .decor-slot-a {right:29%;top:13px;width:123px;height:123px}
        .ambient-decor--gallery .decor-slot-b {left:28%;bottom:-8px;width:290px;height:130px}
        .ambient-decor--gallery .decor-slot-c {left:-56px;bottom:5px;width:165px;height:220px}
        .ambient-decor--gallery .decor-slot-d {right:6%;bottom:0}
        .ambient-decor--gallery .decor-slot-e {right:12%;top:20px;width:55px;height:55px}
        .ambient-decor--stories .decor-slot-a {left:12%;top:26px;width:159px;height:159px}
        .ambient-decor--stories .decor-slot-b {right:14%;top:60px}
        .ambient-decor--stories .decor-slot-c {left:-58px;bottom:18px}
        .ambient-decor--stories .decor-slot-d {right:-40px;bottom:4px;width:310px;height:140px}
        .ambient-decor--stories .decor-slot-e {right:28%;top:20px;width:60px;height:60px}
        .ambient-decor--faq .decor-slot-a {left:25%;top:5px;width:190px;height:86px;opacity:.25}
        .ambient-decor--faq .decor-slot-b {right:var(--page-gutter);top:8px;width:78px;height:53px}
        .ambient-decor--faq .decor-slot-c {left:27%;bottom:6px;width:91px;height:91px}
        .ambient-decor--faq .decor-slot-d {left:-60px;top:20px;width:138px;height:184px;opacity:.18}
        .ambient-decor--faq .decor-slot-e {right:9%;bottom:0;width:50px;height:50px}
        .ambient-decor--contact .decor-slot-a {left:32%;top:53px;width:136px;height:136px}
        .ambient-decor--contact .decor-slot-b {right:6%;top:23px}
        .ambient-decor--contact .decor-slot-c {left:-63px;bottom:64px;width:168px;height:224px}
        .ambient-decor--contact .decor-slot-d {right:5%;bottom:-5px;width:280px;height:126px}
        .ambient-decor--contact .decor-slot-e {left:40%;bottom:32px;width:70px;height:70px}
        .ambient-decor--closing,.ambient-decor--footer {--decor-ink:#f6d6a8;--decor-olive:#f5daba;--decor-opacity:.40}
        .ambient-decor--closing .decor-slot-a {left:9%;top:27px;width:133px;height:133px;opacity:.53}
        .ambient-decor--closing .decor-slot-b {left:20%;bottom:26px;width:90px;opacity:.4}
        .ambient-decor--closing .decor-slot-c {right:9%;top:26px;width:165px;height:220px;opacity:.32}
        .ambient-decor--closing .decor-slot-d {left:24%;bottom:-24px;width:52%;height:190px;opacity:.2}
        .ambient-decor--closing .decor-slot-e {right:25%;top:35px;width:67px;height:67px;opacity:.51}
        .ambient-decor--closing .decor-slot-f {left:2%;bottom:16px;width:100px;height:140px;opacity:.3}
        .ambient-decor--footer .decor-slot-a {right:-40px;top:37px;width:202px;height:202px;opacity:.26}
        .ambient-decor--footer .decor-slot-b {left:47%;bottom:14px;width:85px;opacity:.19}
        .ambient-decor--footer .decor-slot-c {right:22%;bottom:0;width:320px;height:144px;opacity:.13}
        .ambient-decor--footer .decor-slot-d {left:1%;top:16px;width:49px;height:49px;opacity:.28}
        /* Leave room for account access without squeezing navigation or touch targets. */
        .nav-profile {position:relative;width:44px;height:44px;min-width:44px;background:var(--profile-bg);color:var(--ink);border-color:var(--sand-deep);box-shadow:inset 0 0 0 3px var(--profile-ring);transition:background .2s,color .2s,border-color .2s,transform .2s}
        .nav-profile .icon {width:21px;height:21px;stroke-width:1.65}
        .nav-profile:hover {background:var(--green);color:#fff;border-color:var(--green);transform:translateY(-1px);box-shadow:none}
        .nav-profile:focus-visible {outline-offset:4px}
        .profile-tooltip {position:absolute;top:calc(100% + 12px);right:0;width:max-content;max-width:215px;padding:8px 12px;border-radius:8px;border:1px solid var(--line);background:var(--paper);color:var(--ink);box-shadow:var(--shadow);font-size:11px;line-height:1.5;font-weight:500;opacity:0;visibility:hidden;transform:translateY(-4px);pointer-events:none;transition:opacity .18s,transform .18s,visibility .18s;z-index:2}
        .nav-profile:hover .profile-tooltip,.nav-profile:focus-visible .profile-tooltip {opacity:1;visibility:visible;transform:translateY(0)}
        @media(min-width:951px) and (max-width:1120px) {
            .nav-bar{gap:16px}.nav-links{gap:14px}.nav-links a{font-size:11px}
            .nav-actions{gap:10px}.nav-actions>.button{gap:8px;padding-inline:12px;font-size:11px}
            .site-header .brand-name{font-size:21px;letter-spacing:3px}
        }
        @media(max-width:1100px) {
            .ambient-decor--collection .decor-slot-a{left:54%;top:23px;width:132px;height:132px;opacity:.35}
            .ambient-decor--collection .decor-slot-c{width:380px;height:113px;top:0}
            .ambient-decor--about .decor-slot-b{left:45%;width:57px}
            .ambient-decor--contact .decor-slot-a{left:33%;top:12px;width:86px;height:86px}
            .ambient-decor--steps .decor-slot-a{left:1%;width:96px;height:96px}
            .ambient-decor--stories .decor-slot-a{left:3%;width:120px;height:120px}
            .ambient-decor--stories .decor-slot-b{right:5%;width:70px}
        }
        @media(max-width:700px) {
            .nav-actions{gap:8px}.nav-actions>.icon-button{width:44px;height:44px;min-width:44px}
            /* On a phone, keep a few visible sketches in section padding, not
               a desktop illustration squeezed behind body copy. */
            .ambient-decor .decor-secondary,.ambient-decor .decor-mark--arch,
            .ambient-decor .decor-mark--palm,.ambient-decor .decor-mark--trail {display:none}
            .ambient-decor .decor-mark--sun{left:auto;right:8px;top:4px;bottom:auto;width:77px;height:77px;opacity:.34}
            .ambient-decor .decor-mark--dots{left:6px;right:auto;top:8px;bottom:auto;width:58px;height:39px;opacity:.32}
            .ambient-decor .decor-mark--dunes{left:auto;right:-20px;top:auto;bottom:0;width:160px;height:72px;opacity:.23}
            .ambient-decor--collection .decor-slot-a{top:10px;right:10px;width:82px;height:82px;opacity:.4}
            .ambient-decor--collection .decor-slot-b{left:calc(var(--page-gutter) + 4px);top:10px;width:57px}
            .ambient-decor--collection .decor-slot-g{display:block;width:155px}
            .ambient-decor--about .decor-slot-a{width:72px;height:72px;right:1px;top:3px}
            .ambient-decor--about .decor-slot-b{top:auto;bottom:8px;left:18px}
            .ambient-decor--signature .decor-slot-b{top:auto;bottom:0;right:-13px;width:76px;height:76px}
            .ambient-decor--steps .decor-slot-a{right:-31px;top:0;opacity:.2}
            .ambient-decor--steps .decor-slot-b{top:auto;bottom:0}
            .ambient-decor--gallery .decor-slot-a{top:0;right:0;width:66px;height:66px}
            .ambient-decor--gallery .decor-slot-d{top:auto;bottom:4px;left:18px}
            .ambient-decor--stories .decor-slot-a{top:4px;right:-18px;opacity:.26}
            .ambient-decor--stories .decor-slot-b{top:13px;left:16px;width:47px}
            .ambient-decor--faq .decor-slot-c{display:block;top:auto;bottom:0;right:-15px;width:66px;height:66px;opacity:.24}
            .ambient-decor--faq .decor-slot-a{display:none}
            .ambient-decor--faq .decor-slot-b{left:auto;right:var(--page-gutter);top:6px}
            .ambient-decor--contact .decor-slot-a{right:8px;top:6px}
            .ambient-decor--closing .decor-slot-a{left:-20px;right:auto;top:18px;width:87px;height:87px;opacity:.39}
            .ambient-decor--closing .decor-slot-b{left:auto;right:12px;top:auto;bottom:22px;opacity:.35}
            .ambient-decor--closing .decor-slot-d{display:block;left:0;right:0;top:auto;bottom:-9px;width:100%;height:110px;opacity:.14}
            .ambient-decor--hero .decor-slot-a{display:block;left:auto;right:10px;top:23px;width:52px;height:52px;opacity:.47}
            .ambient-decor--footer .decor-slot-a{right:-29px;top:34px;width:130px;height:130px;opacity:.20}
            .ambient-decor--footer .decor-slot-b{left:auto;right:15px;top:auto;bottom:14px;opacity:.19}
        }
        @media(max-width:540px) {
            .nav-actions>.button{display:none}
            .site-header .brand{min-width:0}
        }
        @media(hover:none) {.profile-tooltip{display:none}}
        /* 13. Desert after dark. Keep photography natural; change surfaces, not filters.
           This media query follows browser/OS preference live. No stored override,
           theme toggle, build step, or flash-prone JavaScript theme switch is used. */
        @media screen and (prefers-color-scheme:dark) {
            :root {
                color-scheme:dark;
                --paper:#141c18; --white:#202a23; --sand:#212c24; --sand-deep:#3a4638;
                --ink:#f3ede2; --muted:#b4bcae; --terracotta:#e4b18a; --terra-hover:#f0c5a1;
                --line:#364237; --green:#2d4433; --green-soft:#2b3b2e; --gold:#e4bd87;
                --header-bg:rgba(20,28,24,.96); --shadow:0 16px 50px rgba(0,0,0,.20);
                --decor-ink:#ddb184; --decor-olive:#c4cfa9; --decor-opacity:.40;
                --profile-bg:#2c382c; --profile-ring:#141c18;
            }
            ::selection {background:#e4b18a;color:#141c18}
            .site-header.scrolled {box-shadow:0 5px 25px #0003}
            .preview-strip {background:#25392c;color:#e8e9db}
            .brand-tagline {color:#c5c9b7}
            .nav-links a:hover {color:var(--terracotta)}
            .mobile-menu {background:#19231c;box-shadow:0 15px 35px #0005}
            .button-primary {background:#e4b18a;color:#211d16}
            .button-primary:hover {background:#f0c5a1;color:#211d16}
            .button-green {background:#c3cfad;color:#19251b}
            .button-green:hover {background:#d5dfc4;color:#19251b}
            .button-light {background:#f4e9d8;color:#25352a}
            .button-light:hover {background:#fff5e5;color:#25352a}
            .button-outline:hover {background:#2b372c;border-color:#69745c}
            .icon-button {background:#253229;color:var(--ink);border-color:#4c5948}
            .icon-button:hover {background:#384633}
            .nav-profile {background:var(--profile-bg);border-color:#4c5948}
            .nav-profile:hover {background:#e4b18a;color:#211d16;border-color:#e4b18a}
            .hero-actions .button,.custom-card .button,.signature-bottom .button,.closing .button {color:#25352a}
            .finder {background:#202b23;border-color:#43503f;box-shadow:0 14px 40px #0004}
            .finder input,.finder select {color:#d5d9c9}
            select option,select optgroup {background:#202b23;color:var(--ink)}
            .about-stamp {background:#273427;border-color:#43503f;color:#e5bd87}
            .experiences {background:#1b241d;border-color:#303b30}
            .filter-row,.collection-search {border-color:#43503d}
            .filter-chip {border-color:#4a5743;color:#dce0d0}
            .filter-chip:hover {background:#303e2e;border-color:#687457}
            .filter-chip[aria-pressed=true] {background:#c3cfad;color:#19251b;border-color:#c3cfad}
            .filter-saved:not([aria-pressed=true]) {border-color:transparent}
            .collection-search .icon,.result-count {color:#bcc5b0}
            .collection-search input::placeholder {color:#abb69f;opacity:1}
            .package-card {background:#232e25;border-color:#3c4938}
            .package-card:hover {border-color:#687452;box-shadow:0 16px 35px #0004}
            .package-tag {background:rgba(26,35,28,.94);color:#f1e8d6;border:1px solid #b9c2a344;backdrop-filter:blur(8px)}
            .save-button {background:rgba(26,35,28,.94);color:#eadcc5;border:1px solid #b9c2a355}
            .save-button:hover {background:#334230}
            .save-button[aria-pressed=true] {background:#3e3327;color:#f1bd91;border-color:#d59d7199}
            .save-button[aria-pressed=true] .icon {fill:#f1bd91;stroke:#f1bd91}
            .package-meta {color:#b7c1ab}
            .package-bottom {border-color:#3c4938}
            .package-price small,.collection-note {color:#bbc3ad}
            .details-button {background:#2a382b;border-color:#4b5a42;color:#e7ebdc}
            .details-button:hover {background:#c3cfad;border-color:#c3cfad;color:#19251b}
            .custom-card,.signature-panel {background:#263d2d;border:1px solid #435139}
            .custom-card .button:hover,.signature-bottom .button:hover {background:#fff0d8}
            .empty-state {background:#232e25;border-color:#647351}
            .step-number {color:#9caa81}
            .sample-label,.review-card {background:#202c23}
            .review-card>.icon {color:#dba37d}
            .review-author {border-color:#3b4737}
            .review-initials {background:#4a4432;color:#f0d5aa}
            .review-initials.peach {background:#503b2d;color:#f1c59d}
            .review-initials.olive {background:#384b32;color:#d5dfb8}
            .review-author small,.review-note {color:#b2bfa4}
            .faq-list summary .icon {color:#c1cbad}
            .faq-list details[open] summary {color:var(--terracotta)}
            .contact-form-card {background:#202a23}
            .field label .optional,.field-hint {color:#b1bca4}
            .field input,.field select,.field textarea {background:#19241c;border-color:#546048;color:#f3ede2}
            .field input::placeholder,.field textarea::placeholder {color:#a8b39b;opacity:1}
            .field input:focus,.field select:focus,.field textarea:focus {border-color:#e4b18a;box-shadow:0 0 0 3px #e4b18a22}
            .field input[aria-invalid=true],.field textarea[aria-invalid=true],.field select[aria-invalid=true] {border-color:#f19b8c}
            .field input:-webkit-autofill { -webkit-text-fill-color:#f3ede2;caret-color:#f3ede2;box-shadow:0 0 0 100px #263529 inset}
            .check-field {color:#bec7b0}
            .check-field input {accent-color:#ddb18a}
            .form-preview {background:#342f22;border-color:#665639;color:#ebd1a3}
            .form-error {background:#3c2621;border-color:#915d4f;color:#ffc5b4}
            .closing {background:#754a32;color:#fff0db}
            .closing p {color:#f2ddc5}
            .closing .button:hover {background:#fff5e4}
            .site-footer {background:#101912;border-top:1px solid #33412e}
            .footer-brand p,.footer-column a,.footer-column>span,.footer-column>button {color:#bdc9af}
            .footer-column .footer-note,.footer-preview {color:#aebb9f}
            .footer-bottom {border-color:#3c4d34}
            .mobile-bookbar {background:rgba(25,35,28,.98);border-color:#48533d;box-shadow:0 -4px 24px #0005}
            .toast {background:#2b3d2c;border-color:#70835c;color:#f4f1e3;box-shadow:0 10px 35px #0006}
            dialog {background:#1d2820;box-shadow:0 30px 110px #0009}
            dialog::backdrop {background:rgba(5,11,7,.78)}
            .dialog-close {background:#27372a;color:#f4eddc;border-color:#637353;box-shadow:0 3px 15px #0003}
            .dialog-close:hover {background:#3b4c33}
            .included-list .icon {color:#c3cf9e}
            .experience-footer {background:#233026}
            .booking-aside {background:#283529;border-color:#4a5840}
            .booking-total {border-color:#4a5840}
            .stepper {background:#19241c;border-color:#546048}
            .stepper button:hover {background:#34452e}
            .success-icon {background:#344a31;color:#d8e7bc}
            .success-summary {background:#253227}
            .success-warning {background:#352f23;border-color:#64563b;color:#ebd1a3!important}
            .lightbox-dialog {background:#172019}
        }

        /* 14. Fluid, full-width layout — deliberately NO 1240px container cap.
           Page sections fill the viewport; --page-gutter is only an edge inset.
           Text keeps a comfortable line length while cards and imagery expand. */
        .hero-caption {z-index:1}
        .about-grid>*,.contact-grid>*,.faq-grid>* {min-width:0}
        .closing {padding-inline:0}
        @media(min-width:701px) {
            .hero-inner {padding-inline:0}
            .gallery-grid {gap:clamp(16px,1.6vw,30px)}
            .review-grid {gap:clamp(20px,1.6vw,30px)}
        }
        @media(min-width:1200px) {
            h2 {font-size:clamp(56px,3.8vw,72px)}
            .nav-links {gap:clamp(24px,2.2vw,44px)}
            .nav-links a {font-size:13px}
            .nav-actions>.button {font-size:13px;min-height:48px;padding-inline:22px}
            .hero-inner {min-height:clamp(695px,43vw,850px);grid-template-columns:minmax(0,1fr) 305px;gap:clamp(45px,6vw,115px)}
            .hero-copy {max-width:960px}
            .hero h1 {font-size:clamp(86px,6.2vw,120px)}
            .hero-copy>p {font-size:16px;max-width:440px}
            .hero-actions {margin-top:36px}
            .hero-actions .button {min-height:56px;font-size:14px}
            .hero .eyebrow {font-size:11px}
            .hero-caption {font-size:11px}
            .finder {padding:20px;grid-template-columns:1.25fr 1fr .8fr auto}
            .finder label {font-size:10px}
            .finder input,.finder select {font-size:15px}
            .finder-field {padding-inline:clamp(22px,3vw,52px)}
            .benefit strong {font-size:14px}
            .benefit span {font-size:12px}
            .about-grid {grid-template-columns:1fr .95fr;gap:clamp(55px,7vw,128px)}
            .about-photos {height:clamp(550px,35vw,720px);margin-right:0}
            .about-main {height:89%;width:76%;border-radius:260px 260px 14px 14px}
            .about-secondary {height:54%;width:46%;border-radius:180px 180px 14px 14px}
            .about-stamp {right:3%;top:7%}
            .about-caption {font-size:24px;width:190px;bottom:6px}
            .about-copy h2 {max-width:none}
            .about-copy .section-intro {font-size:16px;max-width:55ch}
            .about-points {gap:28px;margin-block:30px}
            .about-point {font-size:14px}
            .about-signature>span {font-size:27px}
            .section-heading>p {font-size:15px;max-width:360px}
            .section-heading {margin-bottom:40px}
            .eyebrow {font-size:11px}
            .filter-chip {font-size:12px;min-height:44px;padding-inline:18px}
            .collection-search {width:min(380px,38%)}
            .collection-search input {font-size:14px}
            .collection-tools {gap:28px}
            .result-count,.sort-select {font-size:12px}
            .sort-select {max-width:190px}
            .packages-grid {gap:clamp(22px,1.6vw,32px)}
            .package-body {padding:24px}
            .package-title {font-size:clamp(26px,1.75vw,32px)}
            .package-teaser {font-size:13px;min-height:46px}
            .package-category {font-size:10px}
            .package-tag {font-size:10px}
            .package-meta {font-size:12px;gap:15px}
            .package-meta .icon {width:15px;height:15px}
            .package-price strong {font-size:21px}
            .package-price small {font-size:10px}
            .package-price span {font-size:11px}
            .details-button {font-size:12px;padding:11px 16px;min-height:45px}
            .save-button {width:42px;height:42px}
            .save-button .icon {width:18px;height:18px}
            .custom-card {padding:clamp(38px,3vw,58px)}
            .custom-card h3 {font-size:clamp(42px,3vw,54px)}
            .custom-card>div {max-width:570px}
            .custom-card p {font-size:14px;max-width:410px}
            .signature-panel {min-height:590px}
            .signature-body {padding:clamp(45px,4.3vw,80px)}
            .signature h2 {font-size:clamp(48px,3.3vw,65px)}
            .signature p {font-size:15px;max-width:54ch}
            .signature-includes {font-size:12px;gap:22px}
            .signature-bottom .button {font-size:13px}
            .signature-image-label {font-size:38px}
            .how-header h2 {font-size:48px}
            .how-grid {gap:clamp(36px,5vw,85px)}
            .how-step h3 {font-size:16px}
            .how-step p {font-size:14px;max-width:54ch}
            .gallery-header h2 {font-size:56px}
            .gallery-header p {font-size:14px}
            .gallery-item>span {font-size:14px}
            .stories-header {max-width:760px}
            .stories-header h2 {font-size:58px}
            .review-card {padding:clamp(28px,2.5vw,46px)}
            .review-card blockquote {font-size:26px}
            .review-author strong {font-size:13px}
            .review-author small {font-size:11px}
            .faq-grid {gap:clamp(60px,7vw,128px)}
            .faq-intro h2 {font-size:54px}
            .faq-intro p,.faq-list details p {font-size:14px;max-width:65ch}
            .faq-list summary {font-size:15px;padding-block:24px}
            .contact-grid {grid-template-columns:.95fr 1.05fr;gap:clamp(65px,7vw,128px)}
            .contact-copy h2 {font-size:clamp(54px,3.8vw,72px);max-width:600px}
            .contact-copy>p {font-size:15px;max-width:48ch}
            .contact-detail strong {font-size:14px}
            .contact-detail small {font-size:12px}
            .contact-mini {max-width:500px}
            .contact-form-card {padding:clamp(35px,3vw,56px)}
            .contact-form-card .field label {font-size:12px}
            .footer-main {gap:clamp(45px,5vw,85px)}
            .footer-brand p {font-size:13px;max-width:330px}
            .footer-column h3 {font-size:13px}
            .footer-column a,.footer-column>span,.footer-column>button {font-size:12px;min-height:36px}
            .footer-column .footer-note {font-size:11px}
            .footer-bottom {font-size:11px}
        }
        @media(min-width:1600px) {
            .packages-grid {grid-template-columns:repeat(4,minmax(0,1fr))}
            .custom-card {grid-column:span 2}
        }

        @media print {.ambient-decor{display:none!important}}

        @media(prefers-reduced-motion:reduce) {
            html{scroll-behavior:auto}*,*::before,*::after{animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important;scroll-behavior:auto!important}.package-card:hover,.button:hover,.hero-postcard:hover{transform:none!important}
        }
        @media print {
            .site-header,.finder-wrap,.mobile-bookbar,.toast,dialog,.contact-form-card,.filter-row,.collection-search-row,.save-button,.closing,.preview-strip{display:none!important}body{background:#fff;color:#111}.section{padding-block:30px}.hero{min-height:0}.hero-inner{min-height:0;padding:30px}.hero-side{display:none}.packages-grid{grid-template-columns:repeat(2,1fr)}.package-card{break-inside:avoid}.site-footer{padding-bottom:0}.reveal{opacity:1!important;visibility:visible!important;transform:none!important}
        }
    </style>
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>
<svg xmlns="http://www.w3.org/2000/svg" width="0" height="0" style="position:absolute;overflow:hidden" aria-hidden="true" focusable="false">
    <defs>
        @foreach ($iconPaths as $name => $path)
        <symbol id="i-{{ $name }}" viewBox="0 0 24 24">{!! $path !!}</symbol>
        @endforeach
        <!-- Decorative symbols are isolated from the interactive icon set. -->
        <symbol id="decor-sun" viewBox="0 0 160 160">
            <g fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round">
                <circle cx="80" cy="80" r="37"/><circle cx="80" cy="80" r="44" opacity=".6"/>
                <path d="M137.00 80.00L149.00 80.00 M132.66 101.81L140.05 104.87 M120.31 120.31L128.79 128.79 M101.81 132.66L104.87 140.05 M80.00 137.00L80.00 149.00 M58.19 132.66L55.13 140.05 M39.69 120.31L31.21 128.79 M27.34 101.81L19.95 104.87 M23.00 80.00L11.00 80.00 M27.34 58.19L19.95 55.13 M39.69 39.69L31.21 31.21 M58.19 27.34L55.13 19.95 M80.00 23.00L80.00 11.00 M101.81 27.34L104.87 19.95 M120.31 39.69L128.79 31.21 M132.66 58.19L140.05 55.13"/>
            </g>
        </symbol>
        <symbol id="decor-dots" viewBox="0 0 93 63"><g fill="currentColor"><circle cx="9" cy="9" r="1.5"/><circle cx="24" cy="9" r="1.5"/><circle cx="39" cy="9" r="1.5"/><circle cx="54" cy="9" r="1.5"/><circle cx="69" cy="9" r="1.5"/><circle cx="84" cy="9" r="1.5"/><circle cx="9" cy="24" r="1.5"/><circle cx="24" cy="24" r="1.5"/><circle cx="39" cy="24" r="1.5"/><circle cx="54" cy="24" r="1.5"/><circle cx="69" cy="24" r="1.5"/><circle cx="84" cy="24" r="1.5"/><circle cx="9" cy="39" r="1.5"/><circle cx="24" cy="39" r="1.5"/><circle cx="39" cy="39" r="1.5"/><circle cx="54" cy="39" r="1.5"/><circle cx="69" cy="39" r="1.5"/><circle cx="84" cy="39" r="1.5"/><circle cx="9" cy="54" r="1.5"/><circle cx="24" cy="54" r="1.5"/><circle cx="39" cy="54" r="1.5"/><circle cx="54" cy="54" r="1.5"/><circle cx="69" cy="54" r="1.5"/><circle cx="84" cy="54" r="1.5"/></g></symbol>
        <symbol id="decor-dunes" viewBox="0 0 200 90">
            <g fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round">
                <path d="M3 43Q46 7 96 35T197 28M3 57Q51 21 101 49T197 42M3 71Q57 37 106 64T197 56"/>
            </g>
        </symbol>

        <symbol id="decor-arch" viewBox="0 0 180 240">
            <g fill="none" stroke="currentColor" stroke-width="1.35" stroke-linecap="round">
                <path d="M16 232V94a74 74 0 0 1 148 0v138M31 232V94a59 59 0 0 1 118 0v138M46 232V94a44 44 0 0 1 88 0v138M61 232V94a29 29 0 0 1 58 0v138"/>
                <path d="M9 232h162M72 171q18-15 36 0M72 182q18-15 36 0"/><circle cx="90" cy="139" r="10"/>
            </g>
        </symbol>
        <symbol id="decor-sparkles" viewBox="0 0 120 120">
            <g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="m49 19 7 23 23 7-23 7-7 23-7-23-23-7 23-7ZM94 77l3 10 10 3-10 3-3 10-3-10-10-3 10-3Z"/>
                <path d="M92 18v12m-6-6h12M18 87v8m-4-4h8"/>
            </g><g fill="currentColor"><circle cx="80" cy="9" r="2"/><circle cx="18" cy="20" r="2"/><circle cx="67" cy="103" r="2"/></g>
        </symbol>
        <symbol id="decor-trail" viewBox="0 0 260 100">
            <g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                <path d="M9 78C66 73 21 14 88 16s37 73 104 49 45-49 59-52" stroke-dasharray="1 9"/>
                <circle cx="9" cy="78" r="4"/><circle cx="251" cy="13" r="6"/>
            </g>
        </symbol>
        <symbol id="decor-desert" viewBox="0 0 640 190">
            <g fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round">
                <path d="M1 127c77-32 120-52 203-24s117 35 177 0 144-45 258 17M1 145c87-29 130-45 211-17s120 22 185-5 142-30 242 18M1 164c91-25 148-23 218 0s119 11 192-9 144-15 228 9"/>
                <path d="M321 97a38 38 0 1 1 59-34M327 22l-8-10M354 12V1M383 22l8-10M405 47l13-5M313 49l-13-5"/>
                <path d="m91 63 6 15 15 6-15 6-6 15-6-15-15-6 15-6Z"/><circle cx="484" cy="67" r="3"/>
            </g>
        </symbol>
        <symbol id="decor-palm" viewBox="0 0 150 210">
            <g fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                <path d="M72 198q14-80 3-138M81 198q15-78-2-138M75 62Q34 31 6 66q34-15 63 3M77 61Q57 12 20 18q30 14 49 46M77 58Q83 10 111 5q-17 27-30 59M80 64q34-36 64-9-39-8-60 15M82 69q52-7 59 31-28-29-60-25M73 70Q26 61 14 97q27-19 60-21M66 198h30"/>
                <path d="m78 105 9 2m-8 18 10 2m-10 18 10 2m-11 18 10 2m-12 18 10 2" opacity=".6"/>
            </g>
        </symbol>
    </defs>
</svg>
@if ($site['demoContent'] || !$bookingEndpoint || !$contactEndpoint)
<div class="preview-strip">
    @if ($site['demoContent'])
    <strong>Design preview</strong> · Sample experiences, prices & guest stories.
    @endif
    @if (!$bookingEndpoint && !$contactEndpoint)
    Forms are not live.
    @elseif (!$bookingEndpoint)
    Booking requests are in preview mode.
    @elseif (!$contactEndpoint)
    The contact form is in preview mode.
    @endif
</div>
@endif
<header class="site-header" id="site-header">
    <div class="container nav-bar">
        <a class="brand" href="#home" aria-label="{{ $site['name'] }} home">
            <svg class="brand-symbol" viewBox="0 0 52 52" fill="none" aria-hidden="true"><path d="M7 43V25a19 19 0 0 1 38 0v18" stroke="currentColor" stroke-width="1.5"/><circle cx="26" cy="22" r="7" fill="currentColor"/><path d="M9 39c13-14 20-5 34-7M9 44c15-12 23-3 34-7" stroke="currentColor" stroke-width="1.5"/><path d="M26 3V0M9 10 7 8m36 2 2-2" stroke="currentColor" stroke-width="1.5"/></svg>
            <span><span class="brand-name">{{ $site['name'] }}</span><span class="brand-tagline">{{ $site['tagline'] }}</span></span>
        </a>
        <nav class="nav-links" aria-label="Main navigation">
            <a href="#experiences" data-nav="experiences">Experiences</a>
            <a href="#about" data-nav="about">Our story</a>
            <a href="#moments" data-nav="moments">The moments</a>
            <a href="#stories" data-nav="stories">Guest stories</a>
            <a href="#contact" data-nav="contact">Get in touch</a>
        </nav>
        <div class="nav-actions">
            <a class="button button-green" href="#experiences">Find my escape {!! $icon('arrow-up') !!}</a>
            @if ($site['loginUrl'])
            <a class="icon-button nav-profile" href="{{ $site['loginUrl'] }}" aria-label="Owner login" title="Owner login">
                {!! $icon('user') !!}<span class="profile-tooltip" aria-hidden="true">Owner login</span>
            </a>
            @else
            <button class="icon-button nav-profile" type="button" data-account-preview aria-label="Owner login, coming soon" title="Owner login · coming soon">
                {!! $icon('user') !!}<span class="profile-tooltip" aria-hidden="true">Owner login · coming soon</span>
            </button>
            @endif
            <button class="icon-button menu-toggle" id="menu-toggle" type="button" aria-label="Open navigation" aria-controls="mobile-menu" aria-expanded="false">{!! $icon('menu') !!}</button>
        </div>
    </div>
    <nav class="mobile-menu" id="mobile-menu" aria-label="Mobile navigation" hidden>
        <a href="#experiences">Explore experiences {!! $icon('arrow-up') !!}</a>
        <a href="#about">Our story {!! $icon('arrow-up') !!}</a>
        <a href="#moments">The moments {!! $icon('arrow-up') !!}</a>
        <a href="#stories">Guest stories {!! $icon('arrow-up') !!}</a>
        <a href="#faq">Before you go {!! $icon('arrow-up') !!}</a>
        <a href="#contact">Get in touch {!! $icon('arrow-up') !!}</a>
    </nav>
</header>
<main id="main">
    <section class="hero" id="home" aria-labelledby="hero-title">
        <div class="ambient-decor ambient-decor--hero" aria-hidden="true">
            <svg class="decor-mark decor-mark--sparkles decor-slot-a" viewBox="0 0 120 120" aria-hidden="true" focusable="false"><use href="#decor-sparkles"></use></svg>
            <svg class="decor-mark decor-mark--trail decor-slot-b" viewBox="0 0 260 100" aria-hidden="true" focusable="false"><use href="#decor-trail"></use></svg>
            <svg class="decor-mark decor-mark--dunes decor-slot-c decor-secondary" viewBox="0 0 200 90" aria-hidden="true" focusable="false"><use href="#decor-dunes"></use></svg>
        </div>
        <img class="hero-photo" src="{{ $img($photos['hero'], 1920) }}" srcset="{{ $img($photos['hero'], 800) }} 800w, {{ $img($photos['hero'], 1280) }} 1280w, {{ $img($photos['hero'], 1920) }} 1920w" sizes="100vw" width="1920" height="1280" alt="A glowing sunset over the rocky Agafay landscape" fetchpriority="high" decoding="async">
        <div class="container hero-inner">
            <div class="hero-copy">
                <div class="eyebrow hero-animate">Marrakech, Morocco · Beyond the ordinary</div>
                <h1 id="hero-title"><span class="hero-line hero-animate">A different</span><span class="hero-line hero-animate">kind of day.</span><span class="hero-line hero-animate"><em>A lasting feeling.</em></span></h1>
                <p class="hero-animate">Camel trails. Golden skies. Mint tea, poured slowly. Discover the Agafay moments you will take home with you.</p>
                <div class="hero-actions hero-animate">
                    <a class="button" href="#experiences">Explore the experiences {!! $icon('arrow-up') !!}</a>
                    <a class="text-link" href="#about">A little about us {!! $icon('arrow') !!}</a>
                </div>
            </div>
            <div class="hero-side">
                <div class="hero-seal" aria-hidden="true"><span>Less ordinary</span>{!! $icon('sun') !!}<span>More Morocco</span></div>
                <button class="hero-postcard" type="button" data-details="camel-sunset" aria-label="Explore the sunset camel ride and mint tea experience">
                    <img src="{{ $img($photos['camel'], 300) }}" width="90" height="105" alt="" decoding="async">
                    <span class="postcard-copy"><small>The golden-hour edit</small><strong>Chase a softer<br>kind of sunset.</strong><span class="postcard-link">Discover this escape {!! $icon('arrow-up') !!}</span></span>
                </button>
            </div>
        </div>
        <div class="hero-caption">{!! $icon('pin') !!} A little beyond Marrakech. A world away.</div>
    </section>
    <div class="container finder-wrap">
        <form class="finder" id="finder-form" aria-label="Find your preferred experience">
            <div class="finder-field">{!! $icon('compass') !!}<div><label for="finder-category">Your kind of escape</label><select id="finder-category" name="category"><option value="all">A little of everything</option><option value="adventure">A little adventure</option><option value="food">Food & culture</option><option value="relax">Time to slow down</option><option value="private">Something private</option></select></div></div>
            <div class="finder-field">{!! $icon('calendar') !!}<div><label for="finder-date">Your preferred day</label><input id="finder-date" name="date" type="date" aria-describedby="finder-note"></div></div>
            <div class="finder-field">{!! $icon('users') !!}<div><label for="finder-guests">Good company</label><select id="finder-guests" name="guests"><option value="1">1 guest</option><option value="2" selected>2 guests</option><option value="3">3 guests</option><option value="4">4 guests</option><option value="5">5 guests</option><option value="6">6 guests</option><option value="7">7 guests</option><option value="8">8 guests</option><option value="9">9 guests</option><option value="10">10 guests</option><option value="11">11 guests</option><option value="12">12 guests</option></select></div></div>
            <button class="button button-primary" type="submit">Find my experience {!! $icon('search') !!}</button>
            <p id="finder-note" class="sr-only">Your date and guest count will be carried into the request form. This is not a live availability search.</p>
        </form>
    </div>
    <div class="container benefit-strip" aria-label="A simpler way to plan">
        <div class="benefit">{!! $icon('compass') !!}<div><strong>A day that feels like you</strong><span>Adventure, culture, or a slower pace</span></div></div>
        <div class="benefit">{!! $icon('chat') !!}<div><strong>A conversation, not a checkout</strong><span>Request first. Confirm the details together.</span></div></div>
        <div class="benefit">{!! $icon('heart') !!}<div><strong>Room for the little moments</strong><span>Because the best part is how it feels</span></div></div>
    </div>
    <section class="decorated-section section" id="about" aria-labelledby="about-title">
        <div class="ambient-decor ambient-decor--about" aria-hidden="true">
            <svg class="decor-mark decor-mark--sun decor-slot-a" viewBox="0 0 160 160" aria-hidden="true" focusable="false" data-decor-drift><use href="#decor-sun"></use></svg>
            <svg class="decor-mark decor-mark--dots decor-slot-b" viewBox="0 0 93 63" aria-hidden="true" focusable="false"><use href="#decor-dots"></use></svg>
            <svg class="decor-mark decor-mark--arch decor-slot-c decor-secondary" viewBox="0 0 180 240" aria-hidden="true" focusable="false"><use href="#decor-arch"></use></svg>
            <svg class="decor-mark decor-mark--dunes decor-slot-d" viewBox="0 0 200 90" aria-hidden="true" focusable="false"><use href="#decor-dunes"></use></svg>
            <svg class="decor-mark decor-mark--sparkles decor-slot-e decor-secondary" viewBox="0 0 120 120" aria-hidden="true" focusable="false"><use href="#decor-sparkles"></use></svg>
        </div>
        <div class="container about-grid">
            <div class="about-photos reveal">
                <img class="about-main" src="{{ $img($photos['camp'], 850) }}" width="650" height="850" loading="lazy" decoding="async" alt="An inviting Moroccan terrace overlooking the Agafay hills">
                <img class="about-secondary" src="{{ $img($photos['tea'], 600) }}" width="420" height="600" loading="lazy" decoding="async" alt="Mint tea being poured at a Moroccan desert camp">
                <div class="about-stamp" aria-hidden="true">{!! $icon('sunset') !!}</div>
                <span class="about-caption">A little closer<br>to the real thing.</span>
            </div>
            <div class="about-copy reveal">
                <div class="eyebrow">Our story, your next chapter</div>
                <h2 id="about-title">Not just a place.<br><em>A way to feel.</em></h2>
                <p class="section-intro">We believe the best travel days are not always the busiest ones. Sometimes they are a quiet trail, an open horizon, and a warm welcome over a glass of mint tea.</p>
                <p class="section-intro">That is the idea behind {{ $site['name'] }}: a collection of experiences for slowing down, trying something new, and making a little more of your time in Morocco.</p>
                <div class="about-points">
                    <div class="about-point">{!! $icon('check') !!}<span>Find your own<br>kind of adventure</span></div>
                    <div class="about-point">{!! $icon('check') !!}<span>Make space for<br>something memorable</span></div>
                </div>
                <div class="about-signature"><span>See you beyond the city.</span><a class="text-link" href="#experiences">Find your moment {!! $icon('arrow-up') !!}</a></div>
            </div>
        </div>
    </section>
    <section class="decorated-section section experiences" id="experiences" aria-labelledby="experiences-title">
        <div class="ambient-decor ambient-decor--collection" aria-hidden="true">
            <svg class="decor-mark decor-mark--sun decor-slot-a" viewBox="0 0 160 160" aria-hidden="true" focusable="false" data-decor-drift><use href="#decor-sun"></use></svg>
            <svg class="decor-mark decor-mark--dots decor-slot-b" viewBox="0 0 93 63" aria-hidden="true" focusable="false"><use href="#decor-dots"></use></svg>
            <svg class="decor-mark decor-mark--desert decor-slot-c decor-secondary" viewBox="0 0 640 190" aria-hidden="true" focusable="false"><use href="#decor-desert"></use></svg>
            <svg class="decor-mark decor-mark--arch decor-slot-d" viewBox="0 0 180 240" aria-hidden="true" focusable="false"><use href="#decor-arch"></use></svg>
            <svg class="decor-mark decor-mark--dots decor-slot-e decor-secondary" viewBox="0 0 93 63" aria-hidden="true" focusable="false"><use href="#decor-dots"></use></svg>
            <svg class="decor-mark decor-mark--sparkles decor-slot-f decor-secondary" viewBox="0 0 120 120" aria-hidden="true" focusable="false"><use href="#decor-sparkles"></use></svg>
            <svg class="decor-mark decor-mark--dunes decor-slot-g decor-secondary" viewBox="0 0 200 90" aria-hidden="true" focusable="false"><use href="#decor-dunes"></use></svg>
        </div>
        <div class="container">
            <div class="section-heading reveal">
                <div><div class="eyebrow">The experience collection</div><h2 id="experiences-title">Choose a day.<br><em>Make it a story.</em></h2></div>
                <p>For the thrill-seekers, the sunset-chasers, and the “just one more cup of tea” people. There is an escape for you.</p>
            </div>
            <div class="collection-toolbar">
                <div class="filter-row">
                    <div class="filter-chips" role="group" aria-label="Filter by experience category">
                        @foreach ($categories as $key => $label)
                        <button class="filter-chip" type="button" data-category="{{ $key }}" aria-pressed="{{ $key === 'all' ? 'true' : 'false' }}">{{ $label }}</button>
                        @endforeach
                    </div>
                    <button class="filter-chip filter-saved" type="button" id="saved-filter" aria-pressed="false">{!! $icon('heart') !!} Saved <span id="saved-count">0</span></button>
                </div>
                <div class="collection-search-row">
                    <div class="collection-search">{!! $icon('search') !!}<label class="sr-only" for="package-search">Search experiences</label><input id="package-search" type="search" placeholder="Find a little adventure…" maxlength="100" autocomplete="off"></div>
                    <div class="collection-tools"><span id="result-count" class="result-count" role="status" aria-live="polite">{{ count($packages) }} experiences to discover</span><label class="sr-only" for="package-sort">Sort experiences</label><select class="sort-select" id="package-sort"><option value="featured">Our collection order</option><option value="price-asc">Price: low to high</option><option value="price-desc">Price: high to low</option></select></div>
                </div>
            </div>
            <div class="packages-grid" id="packages-grid">
                @foreach ($packages as $package)
                <article class="package-card" data-package="{{ $package['id'] }}" aria-labelledby="title-{{ $package['id'] }}">
                    <div class="package-media">
                        <button class="package-image-button" type="button" data-details="{{ $package['id'] }}" aria-label="View {{ $package['title'] }} details"><img src="{{ $img($package['image'], 800) }}" srcset="{{ $img($package['image'], 500) }} 500w, {{ $img($package['image'], 800) }} 800w" sizes="(max-width:480px) calc(100vw - 40px), (max-width:950px) 45vw, 30vw" width="800" height="525" loading="lazy" decoding="async" alt="{{ $package['alt'] }}"></button>
                        <span class="package-tag">{{ $package['tag'] }}</span>
                        <button class="icon-button save-button" type="button" data-save="{{ $package['id'] }}" aria-label="Save {{ $package['title'] }}" aria-pressed="false">{!! $icon('heart') !!}</button>
                    </div>
                    <div class="package-body">
                        <div class="package-category">{{ $package['categoryLabel'] }}</div>
                        <h3 class="package-title" id="title-{{ $package['id'] }}"><button type="button" data-details="{{ $package['id'] }}">{{ $package['title'] }}</button></h3>
                        <p class="package-teaser">{{ $package['teaser'] }}</p>
                        <div class="package-meta"><span>{!! $icon('clock') !!} {{ $package['duration'] }}</span><span>{!! $icon('pin') !!} Agafay, Morocco</span></div>
                        <div class="package-bottom"><div class="package-price"><small>From</small><strong>{{ $money($package['price']) }}</strong><span>/ guest</span></div><button class="details-button" type="button" data-details="{{ $package['id'] }}" aria-label="Explore {{ $package['title'] }}">Explore {!! $icon('arrow-up') !!}</button></div>
                    </div>
                </article>
                @endforeach
                <aside class="custom-card" id="custom-card">
                    <span class="custom-card-symbol" aria-hidden="true">{!! $icon('sun') !!}</span>
                    <div><div class="eyebrow">Some moments deserve their own plan</div><h3>Not a package person?<br>Let’s make it yours.</h3><p>A birthday, a group of friends, or a beautiful idea you have not quite put into words. Tell us what you are dreaming of.</p><a class="button" href="#contact" data-custom-inquiry>Create my kind of day {!! $icon('arrow-up') !!}</a></div>
                </aside>
            </div>
            <div id="empty-state" class="empty-state" hidden>{!! $icon('compass') !!}<h3>A different path, perhaps?</h3><p id="empty-message">No experiences match these filters. Try another category or search.</p><button class="button button-green" id="reset-filters" type="button">Show all experiences {!! $icon('arrow') !!}</button></div>
            @if ($site['demoContent'])
            <p class="collection-note">Sample rates in {{ $site['currency'] }} per guest. Photos and itineraries are illustrative. Transfers, availability, and final prices must be confirmed.</p>
            @else
            <p class="collection-note">Rates in {{ $site['currency'] }} per guest. Request availability and a final quote before making travel arrangements.</p>
            @endif
            <noscript><p class="collection-note">JavaScript is required for filters, activity details, saved experiences, and forms. Enable it to use the booking interface.</p></noscript>
        </div>
    </section>
    @if ($featuredPackage)
    <section class="decorated-section signature" aria-labelledby="signature-title">
        <div class="ambient-decor ambient-decor--signature" aria-hidden="true">
            <svg class="decor-mark decor-mark--dots decor-slot-a" viewBox="0 0 93 63" aria-hidden="true" focusable="false"><use href="#decor-dots"></use></svg>
            <svg class="decor-mark decor-mark--sun decor-slot-b" viewBox="0 0 160 160" aria-hidden="true" focusable="false" data-decor-drift><use href="#decor-sun"></use></svg>
            <svg class="decor-mark decor-mark--arch decor-slot-c decor-secondary" viewBox="0 0 180 240" aria-hidden="true" focusable="false"><use href="#decor-arch"></use></svg>
            <svg class="decor-mark decor-mark--sparkles decor-slot-d" viewBox="0 0 120 120" aria-hidden="true" focusable="false"><use href="#decor-sparkles"></use></svg>
            <svg class="decor-mark decor-mark--trail decor-slot-e decor-secondary" viewBox="0 0 260 100" aria-hidden="true" focusable="false"><use href="#decor-trail"></use></svg>
        </div>
        <div class="container signature-panel reveal">
            <div class="signature-media"><img src="{{ $img($photos['picnic'], 1000) }}" width="900" height="1100" loading="lazy" decoding="async" alt="A couple enjoying the sunset across Agafay"><span class="signature-image-label">The city can wait.</span></div>
            <div class="signature-body">
                <div class="eyebrow">The signature escape</div>
                <h2 id="signature-title">A little adventure.<br>A beautiful sunset.<br><em>All in one day.</em></h2>
                <p>Follow the trails. Ride into the evening. Then gather around the table as the day turns into one of your favorite travel stories.</p>
                <div class="signature-includes"><span>{!! $icon('compass') !!} Quad adventure</span><span>{!! $icon('sunset') !!} Camel ride</span><span>{!! $icon('cup') !!} Dinner & tea</span></div>
                <div class="signature-bottom"><div class="signature-price"><small>{{ $featuredPackage['duration'] }} · A full afternoon of memories</small><strong>{{ $money($featuredPackage['price']) }}</strong><span>from / guest</span></div><button class="button" type="button" data-details="{{ $featuredPackage['id'] }}">Explore this escape {!! $icon('arrow-up') !!}</button></div>
            </div>
        </div>
    </section>
    @endif
    <section class="decorated-section how" aria-labelledby="how-title">
        <div class="ambient-decor ambient-decor--steps" aria-hidden="true">
            <svg class="decor-mark decor-mark--sun decor-slot-a" viewBox="0 0 160 160" aria-hidden="true" focusable="false" data-decor-drift><use href="#decor-sun"></use></svg>
            <svg class="decor-mark decor-mark--dots decor-slot-b" viewBox="0 0 93 63" aria-hidden="true" focusable="false"><use href="#decor-dots"></use></svg>
            <svg class="decor-mark decor-mark--arch decor-slot-c decor-secondary" viewBox="0 0 180 240" aria-hidden="true" focusable="false"><use href="#decor-arch"></use></svg>
            <svg class="decor-mark decor-mark--dunes decor-slot-d" viewBox="0 0 200 90" aria-hidden="true" focusable="false"><use href="#decor-dunes"></use></svg>
            <svg class="decor-mark decor-mark--sparkles decor-slot-e decor-secondary" viewBox="0 0 120 120" aria-hidden="true" focusable="false"><use href="#decor-sparkles"></use></svg>
        </div>
        <div class="container">
            <div class="how-header reveal"><div class="eyebrow">Less planning. More looking forward.</div><h2 id="how-title">Your next story starts <em>simply.</em></h2></div>
            <div class="how-grid">
                <div class="how-step reveal"><span class="step-number">01</span><h3>Find your kind of day</h3><p>Explore the collection. Read the details. Save the experiences that make you smile.</p></div>
                <div class="how-step reveal"><span class="step-number">02</span><h3>Tell us a little about you</h3><p>Choose a preferred date, add your guests, and share your contact details in the short form.</p></div>
                <div class="how-step reveal"><span class="step-number">03</span><h3>Confirm it, together</h3><p>The operator can follow up with availability, the final quote, and the details of your day.</p></div>
            </div>
        </div>
    </section>
    <section class="decorated-section gallery-section" id="moments" aria-labelledby="moments-title">
        <div class="ambient-decor ambient-decor--gallery" aria-hidden="true">
            <svg class="decor-mark decor-mark--sun decor-slot-a" viewBox="0 0 160 160" aria-hidden="true" focusable="false" data-decor-drift><use href="#decor-sun"></use></svg>
            <svg class="decor-mark decor-mark--dunes decor-slot-b" viewBox="0 0 200 90" aria-hidden="true" focusable="false"><use href="#decor-dunes"></use></svg>
            <svg class="decor-mark decor-mark--arch decor-slot-c decor-secondary" viewBox="0 0 180 240" aria-hidden="true" focusable="false"><use href="#decor-arch"></use></svg>
            <svg class="decor-mark decor-mark--dots decor-slot-d" viewBox="0 0 93 63" aria-hidden="true" focusable="false"><use href="#decor-dots"></use></svg>
            <svg class="decor-mark decor-mark--sparkles decor-slot-e decor-secondary" viewBox="0 0 120 120" aria-hidden="true" focusable="false"><use href="#decor-sparkles"></use></svg>
        </div>
        <div class="container">
            <div class="gallery-header reveal"><div><div class="eyebrow">A little visual daydream</div><h2 id="moments-title">Wish you were <em>here.</em></h2><p>Wide horizons, warm welcomes, and the moments in between.</p></div><a class="text-link" href="#experiences">Find your moment {!! $icon('arrow-up') !!}</a></div>
            <div class="gallery-grid">
                <button class="gallery-item" type="button" data-gallery="{{ $photos['landscape'] }}" data-caption="Room to wander" data-credit="https://www.pexels.com/photo/35910045/" aria-label="View full photograph: Room to wander"><img src="{{ $img($photos['landscape'], 700) }}" width="600" height="750" loading="lazy" decoding="async" alt="A small figure walking through the vast Agafay hills"><span>Room to wander {!! $icon('arrow-up') !!}</span></button>
                <button class="gallery-item" type="button" data-gallery="{{ $photos['tea'] }}" data-caption="One more cup" data-credit="https://www.pexels.com/photo/36579351/" aria-label="View full photograph: One more cup"><img src="{{ $img($photos['tea'], 650) }}" width="600" height="750" loading="lazy" decoding="async" alt="Tea being poured from a silver Moroccan teapot"><span>One more cup {!! $icon('arrow-up') !!}</span></button>
                <button class="gallery-item" type="button" data-gallery="{{ $photos['camel'] }}" data-caption="Take the scenic route" data-credit="https://www.pexels.com/photo/36579390/" aria-label="View full photograph: Take the scenic route"><img src="{{ $img($photos['camel'], 700) }}" width="600" height="750" loading="lazy" decoding="async" alt="Camels with colorful woven saddles in Agafay"><span>The scenic route {!! $icon('arrow-up') !!}</span></button>
                <button class="gallery-item" type="button" data-gallery="{{ $photos['breakfast'] }}" data-caption="Mornings, unhurried" data-credit="https://www.pexels.com/photo/18160499/" aria-label="View full photograph: Mornings, unhurried"><img src="{{ $img($photos['breakfast'], 650) }}" width="600" height="750" loading="lazy" decoding="async" alt="A generous breakfast with a view of the desert"><span>Mornings, unhurried {!! $icon('arrow-up') !!}</span></button>
            </div>
        </div>
    </section>
    <section class="decorated-section stories" id="stories" aria-labelledby="stories-title">
        <div class="ambient-decor ambient-decor--stories" aria-hidden="true">
            <svg class="decor-mark decor-mark--sun decor-slot-a" viewBox="0 0 160 160" aria-hidden="true" focusable="false" data-decor-drift><use href="#decor-sun"></use></svg>
            <svg class="decor-mark decor-mark--dots decor-slot-b" viewBox="0 0 93 63" aria-hidden="true" focusable="false"><use href="#decor-dots"></use></svg>
            <svg class="decor-mark decor-mark--arch decor-slot-c decor-secondary" viewBox="0 0 180 240" aria-hidden="true" focusable="false"><use href="#decor-arch"></use></svg>
            <svg class="decor-mark decor-mark--dunes decor-slot-d" viewBox="0 0 200 90" aria-hidden="true" focusable="false"><use href="#decor-dunes"></use></svg>
            <svg class="decor-mark decor-mark--sparkles decor-slot-e decor-secondary" viewBox="0 0 120 120" aria-hidden="true" focusable="false"><use href="#decor-sparkles"></use></svg>
        </div>
        <div class="container">
            <div class="stories-header reveal"><div class="eyebrow">The stories we make room for</div><h2 id="stories-title">Good days.<br><em>Even better memories.</em></h2>
                @if ($site['demoContent'])
                <span class="sample-label">{!! $icon('info') !!} Design preview · illustrative guest stories</span>
                @endif
            </div>
            <div class="review-grid">
                @foreach ($reviews as $review)
                <article class="review-card reveal">{!! $icon('quote') !!}<blockquote>“{{ $review['quote'] }}”</blockquote><div class="review-author"><span class="review-initials {{ $review['color'] }}" aria-hidden="true">{{ $review['initials'] }}</span><div><strong>{{ $review['name'] }}</strong><small>{{ $review['trip'] }}</small></div></div></article>
                @endforeach
            </div>
            @if ($site['demoContent'])
            <p class="review-note">These are sample testimonials for the design, not verified customer reviews. Replace them with real feedback before launch.</p>
            @endif
        </div>
    </section>
    <section class="decorated-section faq-section" id="faq" aria-labelledby="faq-title">
        <div class="ambient-decor ambient-decor--faq" aria-hidden="true">
            <svg class="decor-mark decor-mark--dunes decor-slot-a" viewBox="0 0 200 90" aria-hidden="true" focusable="false"><use href="#decor-dunes"></use></svg>
            <svg class="decor-mark decor-mark--dots decor-slot-b" viewBox="0 0 93 63" aria-hidden="true" focusable="false"><use href="#decor-dots"></use></svg>
            <svg class="decor-mark decor-mark--sun decor-slot-c decor-secondary" viewBox="0 0 160 160" aria-hidden="true" focusable="false" data-decor-drift><use href="#decor-sun"></use></svg>
            <svg class="decor-mark decor-mark--arch decor-slot-d" viewBox="0 0 180 240" aria-hidden="true" focusable="false"><use href="#decor-arch"></use></svg>
            <svg class="decor-mark decor-mark--sparkles decor-slot-e decor-secondary" viewBox="0 0 120 120" aria-hidden="true" focusable="false"><use href="#decor-sparkles"></use></svg>
        </div>
        <div class="container faq-grid">
            <div class="faq-intro reveal"><div class="eyebrow">Before you head out</div><h2 id="faq-title">A few things<br><em>worth knowing.</em></h2><p>A little clarity makes for a much more relaxed day. Here are the questions that help you get started.</p><a class="text-link" href="#contact">Have another question? {!! $icon('arrow-up') !!}</a></div>
            <div class="faq-list">
                @foreach ($faqs as $faq)
                <details><summary>{{ $faq[0] }} {!! $icon('plus') !!}</summary><p>{{ $faq[1] }}</p></details>
                @endforeach
            </div>
        </div>
    </section>
    <section class="decorated-section section" id="contact" aria-labelledby="contact-title">
        <div class="ambient-decor ambient-decor--contact" aria-hidden="true">
            <svg class="decor-mark decor-mark--sun decor-slot-a" viewBox="0 0 160 160" aria-hidden="true" focusable="false" data-decor-drift><use href="#decor-sun"></use></svg>
            <svg class="decor-mark decor-mark--dots decor-slot-b" viewBox="0 0 93 63" aria-hidden="true" focusable="false"><use href="#decor-dots"></use></svg>
            <svg class="decor-mark decor-mark--arch decor-slot-c decor-secondary" viewBox="0 0 180 240" aria-hidden="true" focusable="false"><use href="#decor-arch"></use></svg>
            <svg class="decor-mark decor-mark--dunes decor-slot-d" viewBox="0 0 200 90" aria-hidden="true" focusable="false"><use href="#decor-dunes"></use></svg>
            <svg class="decor-mark decor-mark--sparkles decor-slot-e decor-secondary" viewBox="0 0 120 120" aria-hidden="true" focusable="false"><use href="#decor-sparkles"></use></svg>
        </div>
        <div class="container contact-grid">
            <div class="contact-copy reveal"><div class="eyebrow">Good days start with a hello</div><h2 id="contact-title">Tell us what<br>you’re <em>dreaming of.</em></h2><p>Not sure which experience to choose? Planning something special? Share a little about your trip, and let’s give your idea a place to begin.</p>
                <div class="contact-detail">{!! $icon('pin') !!}<div><strong>Marrakech & Agafay, Morocco</strong><small>The setting for your next travel story</small></div></div>
                <div class="contact-detail">{!! $icon('chat') !!}<div><strong>A little help with the details</strong><small>Your dates, your group, your kind of day</small></div></div>
                @if ($site['email'])
                <div class="contact-detail">{!! $icon('mail') !!}<a href="mailto:{{ $site['email'] }}">{{ $site['email'] }}</a></div>
                @endif
                @if ($site['phone'])
                <div class="contact-detail">{!! $icon('phone') !!}<a href="tel:{{ preg_replace('/[^+0-9]/', '', $site['phone']) }}">{{ $site['phone'] }}</a></div>
                @endif
                @if ($site['whatsapp'])
                <a class="text-link" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $site['whatsapp']) }}" target="_blank" rel="noopener noreferrer">Start a WhatsApp conversation {!! $icon('arrow-up') !!}</a>
                @endif
                <div class="contact-mini"><img src="{{ $img($photos['quadwide'], 700) }}" width="700" height="350" loading="lazy" decoding="async" alt="A guided quad group moving across the Agafay landscape"><span>Your kind of adventure is out there.</span></div>
            </div>
            <div class="contact-form-card">
                <h3 class="form-heading">Let’s plan something lovely.</h3><p class="form-subtitle">A few details are all it takes to get started.</p>
                @if (!$contactEndpoint)
                <div class="form-preview">{!! $icon('info') !!}<span>Preview form. Your message will not be sent or saved yet.</span></div>
                @endif
                <form id="contact-form" method="post" action="{{ $contactEndpoint ?: '#' }}" novalidate>
                    @csrf
                    <div id="contact-errors" class="form-error" role="alert" tabindex="-1" hidden></div>
                    <div class="honeypot" aria-hidden="true"><label for="contact-company">Leave this field empty</label><input id="contact-company" name="company_website" type="text" tabindex="-1" autocomplete="off"></div>
                    <div class="form-grid">
                        <div class="field"><label for="contact-name">Your name *</label><input id="contact-name" name="name" type="text" placeholder="Your full name" autocomplete="name" required minlength="2" maxlength="100"></div>
                        <div class="field"><label for="contact-email">Email address *</label><input id="contact-email" name="email" type="email" placeholder="you@example.com" autocomplete="email" inputmode="email" required maxlength="160"></div>
                        <div class="field"><label for="contact-phone">Phone / WhatsApp <span class="optional">(optional)</span></label><input id="contact-phone" name="phone" type="tel" placeholder="+212 6…" autocomplete="tel" inputmode="tel" maxlength="25"></div>
                        <div class="field"><label for="contact-subject">What are you planning? *</label><select id="contact-subject" name="subject" required><option value="">Choose a topic</option><option value="experience">Help choosing an experience</option><option value="private">A private or custom day</option><option value="group">A group experience</option><option value="question">Something else</option></select></div>
                        <div class="field full"><label for="contact-message">A little about your plans *</label><textarea id="contact-message" name="message" placeholder="Your dates, your group, your dream day…" required minlength="10" maxlength="2000" rows="4"></textarea></div>
                    </div>
                    <label class="check-field"><input name="consent" type="checkbox" value="1" required><span>I agree to be contacted about this inquiry. <button class="inline-button" type="button" data-privacy>How my details are used</button>.</span></label>
                    <button class="button button-green form-submit" type="submit" disabled><span>{{ $contactEndpoint ? 'Send my message' : 'Preview my message' }}</span>{!! $icon('arrow-up') !!}</button>
                    <p class="form-micro">No payment. No obligation. Just a conversation about your plans.</p>
                </form>
            </div>
        </div>
    </section>
    <section class="decorated-section closing" aria-labelledby="closing-title">
        <div class="ambient-decor ambient-decor--closing" aria-hidden="true">
            <svg class="decor-mark decor-mark--sun decor-slot-a" viewBox="0 0 160 160" aria-hidden="true" focusable="false" data-decor-drift><use href="#decor-sun"></use></svg>
            <svg class="decor-mark decor-mark--dots decor-slot-b" viewBox="0 0 93 63" aria-hidden="true" focusable="false"><use href="#decor-dots"></use></svg>
            <svg class="decor-mark decor-mark--arch decor-slot-c decor-secondary" viewBox="0 0 180 240" aria-hidden="true" focusable="false"><use href="#decor-arch"></use></svg>
            <svg class="decor-mark decor-mark--desert decor-slot-d" viewBox="0 0 640 190" aria-hidden="true" focusable="false"><use href="#decor-desert"></use></svg>
            <svg class="decor-mark decor-mark--sparkles decor-slot-e decor-secondary" viewBox="0 0 120 120" aria-hidden="true" focusable="false"><use href="#decor-sparkles"></use></svg>
            <svg class="decor-mark decor-mark--palm decor-slot-f decor-secondary" viewBox="0 0 150 210" aria-hidden="true" focusable="false"><use href="#decor-palm"></use></svg>
        </div><div class="container reveal">{!! $icon('sun') !!}<h2 id="closing-title">Come for the day.<br>Take the feeling home.</h2><p>Your next favorite travel story might start right here.</p><a class="button" href="#experiences">Find my Agafay moment {!! $icon('arrow-up') !!}</a></div></section>
</main>
<footer class="decorated-section site-footer">
        <div class="ambient-decor ambient-decor--footer" aria-hidden="true">
            <svg class="decor-mark decor-mark--sun decor-slot-a" viewBox="0 0 160 160" aria-hidden="true" focusable="false" data-decor-drift><use href="#decor-sun"></use></svg>
            <svg class="decor-mark decor-mark--dots decor-slot-b" viewBox="0 0 93 63" aria-hidden="true" focusable="false"><use href="#decor-dots"></use></svg>
            <svg class="decor-mark decor-mark--dunes decor-slot-c decor-secondary" viewBox="0 0 200 90" aria-hidden="true" focusable="false"><use href="#decor-dunes"></use></svg>
            <svg class="decor-mark decor-mark--sparkles decor-slot-d" viewBox="0 0 120 120" aria-hidden="true" focusable="false"><use href="#decor-sparkles"></use></svg>
        </div>
    <div class="container">
        <div class="footer-main">
            <div class="footer-brand"><a class="brand" href="#home" aria-label="{{ $site['name'] }} home"><svg class="brand-symbol" viewBox="0 0 52 52" fill="none" aria-hidden="true"><path d="M7 43V25a19 19 0 0 1 38 0v18" stroke="currentColor" stroke-width="1.5"/><circle cx="26" cy="22" r="7" fill="currentColor"/><path d="M9 39c13-14 20-5 34-7M9 44c15-12 23-3 34-7" stroke="currentColor" stroke-width="1.5"/></svg><span><span class="brand-name">{{ $site['name'] }}</span><span class="brand-tagline">{{ $site['tagline'] }}</span></span></a><p>For the days that feel a little different.<br>Thoughtful escapes, open horizons,<br>and more of what makes Morocco special.</p></div>
            <div class="footer-column"><h3>A little exploring</h3><a href="#experiences">All experiences</a><a href="#about">Our story</a><a href="#moments">The moments</a><a href="#stories">Guest stories</a></div>
            <div class="footer-column"><h3>A little help</h3><a href="#faq">Before you go</a><a href="#contact">Get in touch</a><a href="#contact" data-custom-inquiry>Private & group trips</a><button type="button" data-privacy>Privacy & your details</button></div>
            <div class="footer-column"><h3>Somewhere worth going</h3><span>Marrakech & Agafay<br>Morocco</span>
                @if ($site['email'])
                <a href="mailto:{{ $site['email'] }}">{{ $site['email'] }}</a>
                @endif
                <small class="footer-note">A request starts the conversation.<br>Your operator confirms the final details.</small>
            </div>
        </div>
        <div class="footer-bottom"><span>© {{ date('Y') }} {{ $site['name'] }}. A different kind of day.</span><span>Photography: <a href="https://www.pexels.com/search/agafay/" target="_blank" rel="noopener noreferrer">Pexels</a> · Illustrative locations</span><a class="text-link" href="#home">Back to the sunshine {!! $icon('arrow-up') !!}</a></div>
        @if ($site['demoContent'])
        <p class="footer-preview">This is a design preview with sample brand content, rates, and testimonials. Confirm the real business details, policies, suppliers, and images before publishing. No verified ratings are claimed.</p>
        @endif
    </div>
</footer>
<div class="mobile-bookbar" id="mobile-bookbar"><div><strong>A day worth remembering.</strong><small>Find your kind of Agafay.</small></div><a class="button button-primary" href="#experiences">Explore {!! $icon('arrow-up') !!}</a></div>
<div class="toast" id="toast" role="status" aria-live="polite" aria-atomic="true"></div>

{{-- Activity details: one reusable dialog, populated safely from the package data. --}}
<dialog id="experience-dialog" class="experience-dialog" aria-labelledby="detail-title">
    <button class="icon-button dialog-close" type="button" data-close aria-label="Close experience details">{!! $icon('close') !!}</button>
    <div class="experience-layout">
        <div class="experience-image"><img id="detail-image" alt="" width="800" height="1100"><div class="experience-image-caption"><span class="eyebrow" id="detail-tag"></span><strong>A day to call<br>your own.</strong><small>{!! $icon('pin') !!} Agafay, Morocco</small></div></div>
        <div class="experience-content">
            <div class="experience-scroll" id="experience-scroll">
                <div class="experience-heading"><div class="eyebrow" id="detail-category"></div><h2 id="detail-title" tabindex="-1">Your experience</h2></div>
                <div class="detail-meta"><span>{!! $icon('clock') !!}<span id="detail-duration"></span></span><span>{!! $icon('sun') !!}<span id="detail-time"></span></span><span>{!! $icon('users') !!}<span id="detail-pace"></span></span></div>
                <div class="detail-tabs" role="tablist" aria-label="Experience information">
                    <button class="detail-tab" id="tab-overview" type="button" role="tab" aria-selected="true" aria-controls="panel-overview" tabindex="0">The experience</button>
                    <button class="detail-tab" id="tab-itinerary" type="button" role="tab" aria-selected="false" aria-controls="panel-itinerary" tabindex="-1">Your day</button>
                    <button class="detail-tab" id="tab-notes" type="button" role="tab" aria-selected="false" aria-controls="panel-notes" tabindex="-1">Good to know</button>
                </div>
                <div class="detail-panel" id="panel-overview" role="tabpanel" aria-labelledby="tab-overview" tabindex="0"><p id="detail-description"></p><h3>Included in this experience</h3><ul id="detail-includes" class="included-list"></ul></div>
                <div class="detail-panel" id="panel-itinerary" role="tabpanel" aria-labelledby="tab-itinerary" tabindex="0" hidden><ol class="itinerary-list" id="detail-itinerary"></ol></div>
                <div class="detail-panel" id="panel-notes" role="tabpanel" aria-labelledby="tab-notes" tabindex="0" hidden><ul class="detail-notes"><li id="detail-note"></li><li>Transfers are not included in the sample rate. Share your hotel or riad for a pickup quote.</li><li>Your operator must confirm the final price, availability, group capacity, and cancellation policy before booking.</li><li>Photos show the kind of experience, not a guaranteed camp or setup. Times and inclusions shown here are sample itinerary details.</li></ul></div>
            </div>
            <div class="experience-footer"><div class="detail-price"><small>From / guest</small><strong id="detail-price"></strong></div><button class="button button-primary" id="detail-book" type="button">Request this experience {!! $icon('arrow-up') !!}</button></div>
        </div>
    </div>
</dialog>

{{-- Request form: preview-only until a real same-origin endpoint is supplied. --}}
<dialog id="booking-dialog" class="booking-dialog" aria-labelledby="booking-title">
    <button class="icon-button dialog-close" type="button" data-close aria-label="Close booking form">{!! $icon('close') !!}</button>
    <div class="booking-header"><div class="eyebrow">Your next story starts here</div><h2 id="booking-title" tabindex="-1">Let’s make a day of it.</h2><p>Share your details. Your preferred date and final quote need confirmation.</p></div>
    <div class="booking-layout">
        <form id="booking-form" method="post" action="{{ $bookingEndpoint ?: '#' }}" novalidate>
            @csrf
            <input id="booking-package-id" name="package_id" type="hidden">
            <div class="honeypot" aria-hidden="true"><label for="booking-company">Leave this field empty</label><input id="booking-company" name="company_website" type="text" tabindex="-1" autocomplete="off"></div>
            @if (!$bookingEndpoint)
            <div class="form-preview">{!! $icon('info') !!}<span>Preview mode. No request will be sent or saved. Please use sample details when testing.</span></div>
            @endif
            <div id="booking-errors" class="form-error" role="alert" tabindex="-1" hidden></div>
            <div class="form-grid">
                <div class="field full"><label for="booking-name">Your full name *</label><input id="booking-name" name="name" type="text" placeholder="How should we call you?" autocomplete="name" required minlength="2" maxlength="100"></div>
                <div class="field"><label for="booking-email">Email address *</label><input id="booking-email" name="email" type="email" placeholder="you@example.com" autocomplete="email" inputmode="email" required maxlength="160"></div>
                <div class="field"><label for="booking-phone">Phone / WhatsApp *</label><input id="booking-phone" name="phone" type="tel" placeholder="+212 6…" autocomplete="tel" inputmode="tel" required maxlength="25" aria-describedby="phone-hint"><small class="field-hint" id="phone-hint">Include your country code.</small></div>
                <div class="field half-mobile"><label for="booking-date">Preferred date *</label><input id="booking-date" name="date" type="date" required></div>
                <div class="field half-mobile"><label for="booking-guests">Number of guests *</label><div class="stepper"><button id="guests-minus" type="button" aria-label="Remove one guest">{!! $icon('minus') !!}</button><input id="booking-guests" name="guests" type="number" value="2" min="1" max="12" step="1" inputmode="numeric" required><button id="guests-plus" type="button" aria-label="Add one guest">{!! $icon('plus') !!}</button></div></div>
                <div class="field"><label for="booking-contact-method">Contact me by *</label><select id="booking-contact-method" name="contact_method" required><option value="whatsapp">WhatsApp</option><option value="email">Email</option><option value="phone">Phone call</option></select></div>
                <div class="field"><label for="booking-hotel">Hotel / riad <span class="optional">(optional)</span></label><input id="booking-hotel" name="hotel" type="text" placeholder="For a pickup quote" maxlength="180"></div>
                <div class="field full"><label for="booking-notes">Anything we should know? <span class="optional">(optional)</span></label><textarea id="booking-notes" name="notes" placeholder="Children’s ages, dietary needs, a special occasion…" rows="3" maxlength="1500"></textarea></div>
            </div>
            <label class="check-field"><input name="consent" type="checkbox" value="1" required><span>I agree to be contacted about this request. I understand this is not a confirmed booking. <button class="inline-button" type="button" data-privacy>Privacy details</button>.</span></label>
            <button class="button button-primary form-submit" type="submit" disabled><span>{{ $bookingEndpoint ? 'Send my booking request' : 'Preview my booking request' }}</span>{!! $icon('arrow-up') !!}</button>
            <p class="form-micro">No payment is collected. Availability and your final quote come next.</p>
        </form>
        <aside class="booking-aside" aria-label="Your selected experience"><img id="booking-image" width="500" height="300" alt=""><div class="booking-aside-body"><small>Your chosen escape</small><h3 id="booking-package-title"></h3><div class="booking-summary-line optional-summary"><span>Duration</span><strong id="booking-duration"></strong></div><div class="booking-summary-line"><span>Your preferred day</span><strong id="booking-date-summary">Choose a date</strong></div><div class="booking-summary-line"><span id="booking-rate-label">Rate × guests</span><strong id="booking-rate"></strong></div><div class="booking-total"><span>Estimated total</span><strong id="booking-total"></strong></div><p>Estimate only. Transfers and optional extras are not included. The operator confirms the final amount.</p></div></aside>
    </div>
</dialog>
<dialog id="success-dialog" class="success-dialog" aria-labelledby="success-title" aria-describedby="success-description">
    <button class="icon-button dialog-close" type="button" data-close aria-label="Close request summary">{!! $icon('close') !!}</button>
    <div class="success-icon" aria-hidden="true">{!! $icon('check') !!}</div><div class="eyebrow" id="success-eyebrow">Your request</div><h2 id="success-title" tabindex="-1">One step closer.</h2><p id="success-description"></p><dl id="success-summary" class="success-summary"></dl><p class="success-warning" id="success-warning"></p><button class="button button-green" type="button" data-close>Back to dreaming {!! $icon('arrow-up') !!}</button>
</dialog>
<dialog id="privacy-dialog" class="info-dialog" aria-labelledby="privacy-title"><button class="icon-button dialog-close" type="button" data-close aria-label="Close privacy information">{!! $icon('close') !!}</button><div class="eyebrow">Your details, explained</div><h2 id="privacy-title" tabindex="-1">A little clarity.</h2>
    @if (!$bookingEndpoint && !$contactEndpoint)
    <p>This is a frontend preview. Your name, email, phone, and messages are not sent to a server or saved in browser storage by these forms. Use sample details when testing. Closing a form keeps your entries only in this open page until you refresh or complete the preview.</p>
    @else
    <p>A connected form sends the details you enter to this website’s operator so they can respond to your inquiry. A form marked “preview” does not send its entries. Review the operator’s published privacy notice for retention, access, and contact information before submitting.</p>
    @endif
    <p>Only the IDs of experiences you save with the heart button are kept on this device. Clearing your browser’s site data removes them. This page does not include analytics or advertising trackers.</p><p>Photography, fonts, and animation files are loaded from Pexels, Google Fonts, and jsDelivr. Loading these files makes requests to those providers.</p><p>The site owner must supply the actual business privacy notice before collecting real customer information. This explanation is not a complete legal policy.</p><button class="button button-green" type="button" id="privacy-back">Got it {!! $icon('check') !!}</button>
</dialog>
<dialog id="lightbox-dialog" class="lightbox-dialog" aria-labelledby="lightbox-title"><button class="icon-button dialog-close" type="button" data-close aria-label="Close photograph">{!! $icon('close') !!}</button><img id="lightbox-image" width="1200" height="900" alt=""><div class="lightbox-caption"><h2 id="lightbox-title" tabindex="-1">An Agafay moment</h2><p>Illustrative photography · <a id="lightbox-credit" href="https://www.pexels.com/" target="_blank" rel="noopener noreferrer">View on Pexels</a></p></div></dialog>
<script id="agafay-data" type="application/json">{!! json_encode($client, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE) !!}</script>
<script>
(() => {
    'use strict';
    // Page behavior is deliberately independent from the animation CDN.
    const $ = (selector, root = document) => root.querySelector(selector);
    const $$ = (selector, root = document) => Array.from(root.querySelectorAll(selector));
    const data = JSON.parse($('#agafay-data').textContent);
    const packages = new Map(data.packages.map(item => [String(item.id), item]));
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const state = {category: 'all', search: '', savedOnly: false, selected: null, planDate: '', planGuests: 2, planRevision: 0};
    const storageKey = 'agafay:saved:v1';
    const moneyFormatter = new Intl.NumberFormat('en-US', {maximumFractionDigits: 0});
    const money = amount => `${data.currency} ${moneyFormatter.format(amount)}`;
    const photo = (url, width = 1100) => `${url}?auto=compress&cs=tinysrgb&w=${width}&q=82`;
    let saved = new Set();
    let toastTimer;
    let searchTimer;
    let activeDialog = null;
    let returnFocus = null;
    let privacyReturn = null;
    let lockedScrollY = 0;
    let previousBodyStyles = null;
    const requestRecords = new WeakMap();
    const busyForms = new Set();

    function icon(name) {
        const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svg.setAttribute('class', 'icon');
        svg.setAttribute('aria-hidden', 'true');
        svg.setAttribute('focusable', 'false');
        const use = document.createElementNS('http://www.w3.org/2000/svg', 'use');
        use.setAttribute('href', `#i-${name}`);
        svg.append(use);
        return svg;
    }
    function toast(message) {
        clearTimeout(toastTimer);
        const element = $('#toast');
        element.textContent = message;
        element.classList.add('visible');
        toastTimer = setTimeout(() => element.classList.remove('visible'), 4400);
    }
    function today() {
        try {
            const parts = new Intl.DateTimeFormat('en-US', {
                timeZone: data.timezone, year: 'numeric', month: '2-digit', day: '2-digit'
            }).formatToParts(new Date());
            const get = type => parts.find(part => part.type === type).value;
            return `${get('year')}-${get('month')}-${get('day')}`;
        } catch (_) {
            const d = new Date();
            return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
        }
    }
    function refreshDateMinimums() {
        const minimum = today();
        $('#finder-date').min = minimum;
        $('#booking-date').min = minimum;
    }
    function dateLabel(value) {
        if (!/^\d{4}-\d{2}-\d{2}$/.test(value || '')) return 'Choose a date';
        const [y, m, d] = value.split('-').map(Number);
        return new Intl.DateTimeFormat('en-GB', {
            day: 'numeric', month: 'short', year: 'numeric', timeZone: 'UTC'
        }).format(new Date(Date.UTC(y, m - 1, d)));
    }
    function normalized(value) {
        return String(value).normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
    }

    // Mobile navigation does not steal focus or capture desktop scrolling.
    const menu = $('#mobile-menu');
    const menuToggle = $('#menu-toggle');
    function setMenu(open, restoreFocus = false) {
        menu.hidden = !open;
        menuToggle.setAttribute('aria-expanded', String(open));
        menuToggle.setAttribute('aria-label', open ? 'Close navigation' : 'Open navigation');
        $('use', menuToggle).setAttribute('href', open ? '#i-close' : '#i-menu');
        if (restoreFocus) menuToggle.focus({preventScroll: true});
    }
    menuToggle.addEventListener('click', () => setMenu(menu.hidden));
    $$('a', menu).forEach(link => link.addEventListener('click', () => setMenu(false)));
    document.addEventListener('click', event => {
        if (!menu.hidden && !event.target.closest('#site-header')) setMenu(false);
    });
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && !menu.hidden) setMenu(false, true);
    });
    window.matchMedia('(min-width: 951px)').addEventListener('change', event => {
        if (event.matches) setMenu(false);
    });
    let scrollQueued = false;
    function updateHeader() {
        $('#site-header').classList.toggle('scrolled', window.scrollY > 16);
        scrollQueued = false;
    }
    window.addEventListener('scroll', () => {
        if (!scrollQueued) { scrollQueued = true; requestAnimationFrame(updateHeader); }
    }, {passive: true});
    updateHeader();

    // Only package IDs are stored. Form values are never written to localStorage.
    function readSaved() {
        try {
            const values = JSON.parse(localStorage.getItem(storageKey) || '[]');
            saved = new Set(Array.isArray(values) ? values.filter(id => packages.has(String(id))).map(String).slice(0, 100) : []);
        } catch (_) { saved = new Set(); }
    }
    function updateSavedButtons() {
        $$('[data-save]').forEach(button => {
            const id = button.dataset.save;
            const item = packages.get(id);
            const isSaved = saved.has(id);
            button.setAttribute('aria-pressed', String(isSaved));
            button.setAttribute('aria-label', `${isSaved ? 'Unsave' : 'Save'} ${item.title}`);
        });
        $('#saved-count').textContent = String(saved.size);
    }
    function applyFilters() {
        const order = $('#package-sort').value;
        let list = [...packages.values()];
        if (order === 'price-asc') list.sort((a, b) => a.price - b.price);
        if (order === 'price-desc') list.sort((a, b) => b.price - a.price);
        const grid = $('#packages-grid');
        const cards = new Map($$('[data-package]', grid).map(card => [card.dataset.package, card]));
        let visible = 0;
        list.forEach(item => {
            const matchesCategory = state.category === 'all' || item.category === state.category;
            const matchesSearch = normalized(`${item.title} ${item.teaser} ${item.categoryLabel} ${item.description}`).includes(state.search);
            const matchesSaved = !state.savedOnly || saved.has(item.id);
            const show = matchesCategory && matchesSearch && matchesSaved;
            const card = cards.get(item.id);
            if (!card) return;
            card.hidden = !show;
            grid.append(card);
            if (show) visible += 1;
        });
        const customCard = $('#custom-card');
        customCard.hidden = state.category !== 'all' || Boolean(state.search) || state.savedOnly;
        grid.append(customCard);
        $('#result-count').textContent = `${visible} ${visible === 1 ? 'experience' : 'experiences'} to discover`;
        $('#empty-state').hidden = visible > 0;
        $('#empty-message').textContent = state.savedOnly && saved.size === 0
            ? 'Your collection starts with a little heart. Save an experience and it will appear here.'
            : 'No experiences match these filters. Try another category or search.';
        $$('[data-category]').forEach(button => button.setAttribute('aria-pressed', String(button.dataset.category === state.category)));
        $('#saved-filter').setAttribute('aria-pressed', String(state.savedOnly));
        if (window.ScrollTrigger) requestAnimationFrame(() => window.ScrollTrigger.refresh());
    }
    $$('[data-category]').forEach(button => button.addEventListener('click', () => {
        state.category = button.dataset.category;
        $('#finder-category').value = state.category;
        applyFilters();
    }));
    $('#saved-filter').addEventListener('click', () => { state.savedOnly = !state.savedOnly; applyFilters(); });
    $('#package-search').addEventListener('input', event => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => { state.search = normalized(event.target.value.trim()); applyFilters(); }, 160);
    });
    $('#package-sort').addEventListener('change', applyFilters);
    $('#reset-filters').addEventListener('click', () => {
        clearTimeout(searchTimer);
        state.category = 'all'; state.search = ''; state.savedOnly = false;
        $('#finder-category').value = 'all'; $('#package-search').value = ''; $('#package-sort').value = 'featured';
        applyFilters();
        $('[data-category="all"]').focus({preventScroll: true});
    });
    readSaved();
    updateSavedButtons();
    window.addEventListener('storage', event => {
        if (event.key === storageKey || event.key === null) { readSaved(); updateSavedButtons(); applyFilters(); }
    });

    $('#finder-form').addEventListener('submit', event => {
        event.preventDefault();
        refreshDateMinimums();
        const dateInput = $('#finder-date');
        dateInput.setCustomValidity(dateInput.value && dateInput.value < today() ? 'Please choose today or a future date.' : '');
        if (!event.currentTarget.reportValidity()) return;
        clearTimeout(searchTimer);
        state.category = $('#finder-category').value;
        state.search = ''; state.savedOnly = false;
        state.planDate = dateInput.value;
        state.planGuests = Number($('#finder-guests').value);
        state.planRevision += 1;
        $('#package-search').value = '';
        applyFilters();
        $('#experiences').scrollIntoView({behavior: reduceMotion.matches ? 'instant' : 'smooth', block: 'start'});
        toast('Preferences kept for your request. Availability is confirmed by the operator.');
    });
    $('#finder-date').addEventListener('input', event => event.target.setCustomValidity(''));

    // Native dialogs give keyboard focus containment and an inert background.
    // Fixed-body locking also avoids background movement on mobile Safari.
    function lockScroll() {
        lockedScrollY = window.scrollY;
        previousBodyStyles = {
            position: document.body.style.position,
            top: document.body.style.top,
            width: document.body.style.width,
            paddingRight: document.body.style.paddingRight
        };
        const scrollbar = window.innerWidth - document.documentElement.clientWidth;
        const bodyPadding = parseFloat(getComputedStyle(document.body).paddingRight) || 0;
        document.body.style.position = 'fixed';
        document.body.style.top = `-${lockedScrollY}px`;
        document.body.style.width = '100%';
        document.body.style.paddingRight = `${bodyPadding + scrollbar}px`;
        document.body.classList.add('has-dialog');
        $('#mobile-bookbar').style.visibility = 'hidden';
    }
    function unlockScroll() {
        if (previousBodyStyles) Object.assign(document.body.style, previousBodyStyles);
        previousBodyStyles = null;
        document.body.classList.remove('has-dialog');
        const scrollBehavior = document.documentElement.style.scrollBehavior;
        document.documentElement.style.scrollBehavior = 'auto';
        window.scrollTo({top: lockedScrollY, behavior: 'instant'});
        document.documentElement.style.scrollBehavior = scrollBehavior;
        $('#mobile-bookbar').style.visibility = '';
    }
    function openModal(dialog, trigger = document.activeElement) {
        setMenu(false);
        if (typeof dialog.showModal !== 'function') {
            toast('Please open this page in a current browser to view activity details and forms.');
            return false;
        }
        if (!activeDialog) { returnFocus = trigger; lockScroll(); }
        else activeDialog.close();
        activeDialog = dialog;
        dialog.showModal();
        dialog.scrollTop = 0;
        const heading = dialog.querySelector('h2[tabindex="-1"]');
        requestAnimationFrame(() => { if (activeDialog === dialog && heading) heading.focus({preventScroll: true}); });
        return true;
    }
    function closeModal() {
        if (!activeDialog) return;
        // Closing privacy returns to the unfinished booking form instead of losing context.
        if (activeDialog.id === 'privacy-dialog' && privacyReturn) { backFromPrivacy(); return; }
        activeDialog.close();
        activeDialog = null;
        privacyReturn = null;
        unlockScroll();
        const focusTarget = returnFocus;
        returnFocus = null;
        requestAnimationFrame(() => {
            if (focusTarget && focusTarget.isConnected && !focusTarget.closest('[hidden]')) focusTarget.focus({preventScroll: true});
        });
    }
    $$('dialog').forEach(dialog => {
        dialog.addEventListener('cancel', event => { event.preventDefault(); closeModal(); });
        dialog.addEventListener('click', event => {
            if (event.target !== dialog) return;
            const r = dialog.getBoundingClientRect();
            if (event.clientX < r.left || event.clientX > r.right || event.clientY < r.top || event.clientY > r.bottom) closeModal();
        });
    });
    function activateTab(tab, moveFocus = false) {
        $$('.detail-tab').forEach(button => {
            const selected = button === tab;
            button.setAttribute('aria-selected', String(selected));
            button.tabIndex = selected ? 0 : -1;
            document.getElementById(button.getAttribute('aria-controls')).hidden = !selected;
        });
        if (moveFocus) tab.focus();
    }
    $$('.detail-tab').forEach((tab, index, tabs) => {
        tab.addEventListener('click', () => activateTab(tab));
        tab.addEventListener('keydown', event => {
            let next = index;
            if (event.key === 'ArrowRight') next = (index + 1) % tabs.length;
            else if (event.key === 'ArrowLeft') next = (index + tabs.length - 1) % tabs.length;
            else if (event.key === 'Home') next = 0;
            else if (event.key === 'End') next = tabs.length - 1;
            else return;
            event.preventDefault(); activateTab(tabs[next], true);
        });
    });
    function showDetails(id, trigger) {
        const item = packages.get(id);
        if (!item) { toast('This experience is not available in the collection.'); return; }
        state.selected = item;
        $('#detail-image').src = photo(item.image);
        $('#detail-image').alt = item.alt;
        $('#detail-category').textContent = item.categoryLabel;
        $('#detail-tag').textContent = item.tag;
        $('#detail-title').textContent = item.title;
        $('#detail-description').textContent = item.description;
        $('#detail-duration').textContent = item.duration;
        $('#detail-time').textContent = item.time;
        $('#detail-pace').textContent = item.pace;
        $('#detail-price').textContent = money(item.price);
        $('#detail-note').textContent = item.note;
        const includes = $('#detail-includes'); includes.replaceChildren();
        item.includes.forEach(text => {
            const li = document.createElement('li');
            const span = document.createElement('span'); span.textContent = text;
            li.append(icon('check'), span); includes.append(li);
        });
        const itinerary = $('#detail-itinerary'); itinerary.replaceChildren();
        item.itinerary.forEach(([title, description]) => {
            const li = document.createElement('li');
            const strong = document.createElement('strong'); strong.textContent = title;
            const p = document.createElement('p'); p.textContent = description;
            li.append(strong, p); itinerary.append(li);
        });
        activateTab($('#tab-overview'));
        $('#experience-scroll').scrollTop = 0;
        openModal($('#experience-dialog'), trigger);
    }
    function clearErrors(form, box) {
        box.hidden = true; box.replaceChildren();
        $$('[aria-invalid="true"]', form).forEach(field => field.removeAttribute('aria-invalid'));
    }
    function setErrors(form, box, messages, fields = {}) {
        box.replaceChildren();
        const intro = document.createElement('strong'); intro.textContent = 'A quick check before we continue:';
        const list = document.createElement('ul');
        [...new Set(messages)].slice(0, 15).forEach(message => {
            const li = document.createElement('li'); li.textContent = String(message).slice(0, 600); list.append(li);
        });
        box.append(intro, list); box.hidden = false;
        Object.keys(fields).forEach(name => {
            const field = form.elements.namedItem(name);
            if (field instanceof HTMLElement) field.setAttribute('aria-invalid', 'true');
        });
        box.focus({preventScroll: true});
        box.scrollIntoView({behavior: reduceMotion.matches ? 'instant' : 'smooth', block: 'nearest'});
    }
    function updateBookingSummary() {
        if (!state.selected) return;
        const input = $('#booking-guests');
        const count = Number(input.value);
        const max = Number(input.max);
        const validCount = input.value !== '' && Number.isInteger(count) && count >= 1 && count <= max;
        $('#booking-rate-label').textContent = validCount ? `${money(state.selected.price)} × ${count} ${count === 1 ? 'guest' : 'guests'}` : 'Rate × guests';
        $('#booking-rate').textContent = validCount ? money(state.selected.price * count) : '—';
        $('#booking-total').textContent = validCount ? money(state.selected.price * count) : '—';
        $('#booking-date-summary').textContent = dateLabel($('#booking-date').value);
        if (!busyForms.has($('#booking-form'))) {
            $('#guests-minus').disabled = count <= 1;
            $('#guests-plus').disabled = count >= max;
        }
    }
    function showBooking() {
        const item = state.selected;
        if (!item) return;
        const form = $('#booking-form');
        if (busyForms.has(form)) { toast('Your previous request is still being sent.'); return; }
        refreshDateMinimums();
        clearErrors(form, $('#booking-errors'));
        const changedPackage = $('#booking-package-id').value !== item.id;
        const changedPlan = form.dataset.planRevision !== String(state.planRevision);
        form.dataset.planRevision = String(state.planRevision);
        $('#booking-package-id').value = item.id;
        $('#booking-image').src = photo(item.image, 600);
        $('#booking-image').alt = item.alt;
        $('#booking-package-title').textContent = item.title;
        $('#booking-duration').textContent = item.duration;
        $('#booking-guests').max = String(item.maxGuests);
        if (changedPackage || changedPlan) {
            $('#booking-guests').value = String(Math.min(item.maxGuests, Math.max(1, state.planGuests)));
            $('#booking-date').value = state.planDate >= today() ? state.planDate : '';
            form.elements.namedItem('consent').checked = false;
        }
        // Preserve contact details while someone compares activities; clear consent per activity.
        updateBookingSummary();
        openModal($('#booking-dialog'));
    }
    $('#detail-book').addEventListener('click', showBooking);
    $('#booking-guests').addEventListener('input', updateBookingSummary);
    $('#booking-date').addEventListener('input', updateBookingSummary);
    $('#guests-minus').addEventListener('click', () => {
        const input = $('#booking-guests');
        input.value = String(Math.max(1, Math.min(Number(input.max), (Number(input.value) || 1) - 1)));
        input.setCustomValidity(''); updateBookingSummary();
    });
    $('#guests-plus').addEventListener('click', () => {
        const input = $('#booking-guests');
        input.value = String(Math.max(1, Math.min(Number(input.max), (Number(input.value) || 0) + 1)));
        input.setCustomValidity(''); updateBookingSummary();
    });

    function showPrivacy() {
        const configured = @json($site['privacyUrl']);
        if (configured) {
            try {
                const url = new URL(configured, window.location.href);
                if (!['https:', 'http:'].includes(url.protocol)) throw new Error('Invalid URL');
                window.open(url.href, '_blank', 'noopener,noreferrer');
                return;
            } catch (_) { toast('The privacy notice URL is not configured correctly.'); return; }
        }
        privacyReturn = activeDialog ? {dialog: activeDialog, focus: document.activeElement, scroll: activeDialog.scrollTop} : null;
        openModal($('#privacy-dialog'));
    }
    function backFromPrivacy() {
        const prior = privacyReturn; privacyReturn = null;
        if (prior) {
            openModal(prior.dialog);
            requestAnimationFrame(() => {
                prior.dialog.scrollTop = prior.scroll;
                if (prior.focus && prior.focus.isConnected) prior.focus.focus({preventScroll: true});
            });
        } else closeModal();
    }
    $('#privacy-back').addEventListener('click', backFromPrivacy);

    document.addEventListener('click', event => {
        const accountPreview = event.target.closest('[data-account-preview]');
        if (accountPreview) {
            event.preventDefault();
            setMenu(false);
            toast('Owner login is coming with the dashboard. No login is connected yet.');
            return;
        }
        const close = event.target.closest('[data-close]');
        if (close) { closeModal(); return; }
        const privacy = event.target.closest('[data-privacy]');
        if (privacy) { event.preventDefault(); showPrivacy(); return; }
        const save = event.target.closest('[data-save]');
        if (save) {
            const id = save.dataset.save;
            if (saved.has(id)) saved.delete(id); else saved.add(id);
            try { localStorage.setItem(storageKey, JSON.stringify([...saved])); } catch (_) { /* Session-only fallback. */ }
            updateSavedButtons();
            if (state.savedOnly) applyFilters();
            toast(saved.has(id) ? 'Saved for a little later.' : 'Removed from your saved experiences.');
            return;
        }
        const detail = event.target.closest('[data-details]');
        if (detail) { showDetails(detail.dataset.details, detail); return; }
        const gallery = event.target.closest('[data-gallery]');
        if (gallery) {
            $('#lightbox-image').src = photo(gallery.dataset.gallery, 1600);
            $('#lightbox-image').alt = $('img', gallery).alt;
            $('#lightbox-title').textContent = gallery.dataset.caption;
            $('#lightbox-credit').href = gallery.dataset.credit;
            openModal($('#lightbox-dialog'), gallery);
            return;
        }
        if (event.target.closest('[data-custom-inquiry]')) $('#contact-subject').value = 'private';
    });

    // Validation improves UX only. Repeat every rule on your Laravel endpoint.
    function validateForm(form, booking) {
        refreshDateMinimums();
        $$('input:not([type="hidden"]), textarea, select', form).forEach(field => {
            field.setCustomValidity(''); field.removeAttribute('aria-invalid');
            if (['text', 'tel', 'email'].includes(field.type) || field.tagName === 'TEXTAREA') field.value = field.value.trim();
            if (field.minLength > 0 && field.value && field.value.length < field.minLength) {
                field.setCustomValidity(`Please enter at least ${field.minLength} characters.`);
            }
        });
        const phone = form.elements.namedItem('phone');
        if (phone && phone.value) {
            const digits = phone.value.replace(/\D/g, '');
            if (!/^\+[0-9 ()\-.]+$/.test(phone.value) || digits.length < 7 || digits.length > 15) {
                phone.setCustomValidity('Enter a valid phone number with + and your country code (7–15 digits).');
            }
        }
        if (booking) {
            const date = form.elements.namedItem('date');
            if (date.value && date.value < today()) date.setCustomValidity('Please choose today or a future date.');
            const guests = form.elements.namedItem('guests');
            const count = Number(guests.value);
            if (!Number.isInteger(count) || count < 1 || count > Number(guests.max)) {
                guests.setCustomValidity(`Choose between 1 and ${guests.max} guests. For a larger group, use the contact form.`);
            }
        }
        const invalid = $$('input,textarea,select', form).filter(field => !field.checkValidity());
        invalid.forEach(field => field.setAttribute('aria-invalid', 'true'));
        if (invalid.length) {
            invalid[0].focus(); invalid[0].reportValidity(); return false;
        }
        return true;
    }
    [$('#booking-form'), $('#contact-form')].forEach(form => {
        $$('input,textarea,select', form).forEach(field => {
            field.addEventListener('input', () => { field.setCustomValidity(''); field.removeAttribute('aria-invalid'); });
            field.addEventListener('change', () => { field.setCustomValidity(''); field.removeAttribute('aria-invalid'); });
        });
        // Remain disabled when JavaScript is unavailable: never silently POST a demo to the page URL.
        $('button[type="submit"]', form).disabled = false;
    });
    function requestId(form, formData) {
        const fingerprint = JSON.stringify([...formData.entries()].filter(([key]) => key !== '_token'));
        const previous = requestRecords.get(form);
        if (previous && previous.fingerprint === fingerprint) return previous.id;
        let id;
        if (window.crypto && crypto.randomUUID) id = crypto.randomUUID();
        else if (window.crypto && crypto.getRandomValues) id = [...crypto.getRandomValues(new Uint8Array(16))].map(n => n.toString(16).padStart(2, '0')).join('');
        else id = `request-${Date.now()}-${Math.random().toString(36).slice(2)}`;
        requestRecords.set(form, {id, fingerprint});
        return id;
    }
    function resolveEndpoint(value) {
        const url = new URL(value, window.location.href);
        if (url.origin !== window.location.origin || !['http:', 'https:'].includes(url.protocol)) {
            throw new Error('This form must use a same-origin booking or contact endpoint. No details were sent.');
        }
        return url.href;
    }
    function setBusy(form, busy) {
        const button = $('button[type="submit"]', form);
        if (busy) {
            busyForms.add(form);
            form.setAttribute('aria-busy', 'true');
            button.dataset.originalText = $('span', button).textContent;
            $('span', button).textContent = 'Sending your request…';
            $$('input,textarea,select,button', form).forEach(field => {
                field.dataset.wasDisabled = field.disabled ? '1' : '0'; field.disabled = true;
            });
            button.classList.add('is-loading');
        } else {
            busyForms.delete(form);
            form.removeAttribute('aria-busy');
            $$('input,textarea,select,button', form).forEach(field => {
                field.disabled = field.dataset.wasDisabled === '1'; delete field.dataset.wasDisabled;
            });
            if (button.dataset.originalText) $('span', button).textContent = button.dataset.originalText;
            button.classList.remove('is-loading');
            updateBookingSummary();
        }
    }
    function renderSuccess(kind, formData, item, preview, response = {}) {
        const booking = kind === 'booking';
        $('#success-eyebrow').textContent = preview ? 'Preview complete · not sent' : 'Request received';
        $('#success-title').textContent = preview ? 'Your preview is ready.' : 'One step closer.';
        $('#success-description').textContent = preview
            ? `This is how your ${booking ? 'booking request' : 'message'} will look. Your details have not been sent to the operator or saved.`
            : (booking ? 'Your request was received. The operator can now contact you to confirm availability, the final quote, and your plans.' : 'Your message was received. The operator can now reply using the contact details you provided.');
        const rows = [];
        if (booking) {
            rows.push(['Your experience', item.title], ['Preferred date', dateLabel(String(formData.get('date')))], ['Guests', String(formData.get('guests'))], ['Estimated total', money(item.price * Number(formData.get('guests')))]);
        } else {
            const subjectLabels = {experience:'Help choosing an experience', private:'A private or custom day', group:'A group experience', question:'Something else'};
            rows.push(['Your name', String(formData.get('name'))], ['Your plans', subjectLabels[formData.get('subject')] || 'General inquiry']);
        }
        rows.push(['Contact email', String(formData.get('email'))]);
        if (!preview && response.reference) rows.push(['Request reference', String(response.reference).slice(0, 100)]);
        const summary = $('#success-summary'); summary.replaceChildren();
        rows.forEach(([label, value]) => {
            const div = document.createElement('div');
            const dt = document.createElement('dt'); dt.textContent = label;
            const dd = document.createElement('dd'); dd.textContent = value;
            div.append(dt, dd); summary.append(div);
        });
        $('#success-warning').textContent = preview
            ? 'Demo only. Connect the Laravel endpoint to receive real requests. No reservation or message has been created.'
            : (booking ? 'This is a request, not a confirmed booking. Wait for the operator’s confirmation before making arrangements. No payment was taken.' : 'No booking or payment was created. Please wait for a reply about your inquiry.');
        privacyReturn = null;
        openModal($('#success-dialog'));
    }
    async function submitForm(event, kind) {
        event.preventDefault();
        const form = event.currentTarget;
        if (busyForms.has(form)) return;
        const booking = kind === 'booking';
        const errorBox = document.getElementById(`${kind}-errors`);
        clearErrors(form, errorBox);
        if (!validateForm(form, booking)) return;
        const payload = new FormData(form);
        if (String(payload.get('company_website') || '').trim()) {
            setErrors(form, errorBox, ['Please leave the anti-spam field empty and try again.']); return;
        }
        const item = booking ? packages.get(String(payload.get('package_id'))) : null;
        if (booking && !item) { setErrors(form, errorBox, ['Please choose an experience before sending a request.']); return; }
        const endpoint = booking ? data.bookingEndpoint : data.contactEndpoint;
        if (!endpoint) {
            renderSuccess(kind, payload, item, true);
            form.reset();
            if (booking) { $('#booking-package-id').value = ''; delete form.dataset.planRevision; }
            requestRecords.delete(form);
            refreshDateMinimums();
            return;
        }
        let url;
        try { url = resolveEndpoint(endpoint); }
        catch (error) { setErrors(form, errorBox, [error.message]); return; }
        const id = requestId(form, payload);
        payload.set('request_id', id);
        // No client-calculated price is sent. The server resolves the package and quote.
        const abort = new AbortController();
        const timer = setTimeout(() => abort.abort(), 20000);
        setBusy(form, true);
        try {
            const response = await fetch(url, {
                method:'POST', body:payload, credentials:'same-origin', redirect:'error', signal:abort.signal,
                headers: {
                    'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest',
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').content, 'Idempotency-Key':id
                }
            });
            let result = null;
            if ((response.headers.get('content-type') || '').includes('application/json')) result = await response.json();
            if (response.status === 422 && result && result.errors) {
                const messages = Object.values(result.errors).flat().filter(message => typeof message === 'string');
                setErrors(form, errorBox, messages.length ? messages : ['Please check your details.'], result.errors);
                return;
            }
            if (response.status === 419) throw new Error('Your session has expired. Refresh the page and try again.');
            if (response.status === 429) throw new Error('Too many requests were made. Please wait a little before trying again.');
            if (response.status === 401 || response.status === 403) throw new Error('The server did not allow this request. Please contact the site operator.');
            if (!response.ok) throw new Error('The server could not complete this request. Your details are still in the form. Please try again later.');
            if (!result || result.success !== true) throw new Error('The server did not return a valid confirmation. Delivery is unconfirmed; please check with the operator before submitting a new request.');
            renderSuccess(kind, payload, item, false, result);
            form.reset();
            if (booking) { $('#booking-package-id').value = ''; delete form.dataset.planRevision; }
            requestRecords.delete(form);
            refreshDateMinimums();
        } catch (error) {
            let message = error.message;
            if (error.name === 'AbortError') message = 'The server took too long to respond. Delivery is unconfirmed. Retry this request or check with the operator before creating a new one.';
            else if (error instanceof TypeError) message = 'We could not confirm delivery. Check your connection and try again. Your entries have been kept in this form.';
            else if (error instanceof SyntaxError) message = 'The server returned an unreadable response. Delivery is unconfirmed; please check with the operator.';
            setErrors(form, errorBox, [message]);
        } finally {
            clearTimeout(timer);
            setBusy(form, false);
        }
    }
    $('#booking-form').addEventListener('submit', event => submitForm(event, 'booking'));
    $('#contact-form').addEventListener('submit', event => submitForm(event, 'contact'));
    refreshDateMinimums();
    document.addEventListener('visibilitychange', () => { if (!document.hidden) refreshDateMinimums(); });

    // Image failures keep the layout intact and show a locally available SVG placeholder.
    // The original alt remains meaningful; an unavailable remote photo is never hidden silently.
    const fallbackSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 600"><rect width="800" height="600" fill="#d9c3a5"/><circle cx="595" cy="160" r="67" fill="#eed6b2"/><path d="M0 415Q175 235 415 399T800 310V600H0Z" fill="#b39b77"/><path d="M0 488Q232 352 464 473T800 397V600H0Z" fill="#897e5b"/><text x="400" y="549" text-anchor="middle" font-family="Arial,sans-serif" font-size="14" letter-spacing="2" fill="#fff6e6">PHOTO TEMPORARILY UNAVAILABLE</text></svg>';
    const fallbackUrl = `data:image/svg+xml;charset=utf-8,${encodeURIComponent(fallbackSvg)}`;
    $$('img').forEach(image => {
        image.addEventListener('error', () => {
            if (image.src === fallbackUrl) return;
            image.removeAttribute('srcset');
            image.src = fallbackUrl;
            image.dataset.photoUnavailable = 'true';
        });
        if (image.getAttribute('src') && image.complete && image.naturalWidth === 0) image.dispatchEvent(new Event('error'));
    });

    if ('IntersectionObserver' in window) {
        let heroVisible = true;
        let contactVisible = false;
        const updateBookbar = () => $('#mobile-bookbar').classList.toggle('visible', !heroVisible && !contactVisible);
        new IntersectionObserver(entries => { heroVisible = entries[0].isIntersecting; updateBookbar(); }).observe($('#home'));
        new IntersectionObserver(entries => { contactVisible = entries[0].isIntersecting; updateBookbar(); }).observe($('#contact'));
        const navObserver = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                $$('[data-nav]').forEach(link => {
                    if (link.dataset.nav === entry.target.id) link.setAttribute('aria-current', 'location');
                    else link.removeAttribute('aria-current');
                });
            });
        }, {rootMargin:'-12% 0px -65% 0px', threshold:0});
        ['about','experiences','moments','stories','contact'].forEach(id => navObserver.observe(document.getElementById(id)));
    }

    // GSAP is progressive enhancement. No CSS rule hides content while the CDN loads.
    function startAnimations() {
        if (!window.gsap || !window.ScrollTrigger) return;
        try {
            gsap.registerPlugin(ScrollTrigger);
            const mm = gsap.matchMedia();
            mm.add('(prefers-reduced-motion: no-preference)', () => {
                gsap.from('.hero-animate', {y:24, autoAlpha:0, duration:.85, stagger:.1, ease:'power3.out', clearProps:'transform,opacity,visibility'});
                gsap.from('.hero-side', {y:24, autoAlpha:0, duration:1, delay:.45, ease:'power2.out', clearProps:'transform,opacity,visibility'});
                $$('.reveal').forEach(element => {
                    gsap.from(element, {
                        y:30, autoAlpha:0, duration:.85, ease:'power2.out',
                        scrollTrigger:{trigger:element, start:'top 92%', once:true},
                        clearProps:'transform,opacity,visibility'
                    });
                });
                return () => {};
            });
            mm.add('(min-width: 951px) and (prefers-reduced-motion: no-preference)', () => {
                gsap.to('.hero-photo', {yPercent:4, ease:'none', scrollTrigger:{trigger:'.hero', start:'top top', end:'bottom top', scrub:1}});
                gsap.to('.about-stamp', {rotation:28, ease:'none', scrollTrigger:{trigger:'.about-photos', start:'top bottom', end:'bottom top', scrub:1}});
                // Slow, scroll-linked sun movement, desktop only. No perpetual loops.
                $$('[data-decor-drift]').forEach(mark => {
                    const section = mark.closest('section, footer');
                    gsap.to(mark, {rotation:18, y:-10, ease:'none', scrollTrigger:{
                        trigger:section, start:'top bottom', end:'bottom top', scrub:1.5
                    }});
                });
            });
            if (document.fonts && document.fonts.ready) document.fonts.ready.then(() => ScrollTrigger.refresh());
        } catch (_) {
            $$('.reveal, .hero-animate, .hero-side').forEach(element => {
                element.style.opacity = ''; element.style.visibility = ''; element.style.transform = '';
            });
        }
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', startAnimations, {once:true});
    else startAnimations();
})();
</script>
<script defer src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js"></script>
</body>
</html>
