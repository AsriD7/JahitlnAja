@extends('layouts.appPelanggan')

@section('title', 'Dashboard Pelanggan')

@section('content')
   <!-- Category Cards Section -->
    <section id="category-cards" class="category-cards section light-background">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="tab-content" id="category-cards-tabContent">
          <!-- Men's Categories -->
          <div class="tab-pane fade" id="category-cards-men-content" role="tabpanel" aria-labelledby="category-cards-men-tab">
          </div>

          <!-- Women's Categories -->
          <div class="tab-pane fade show active" id="category-cards-women-content" role="tabpanel" aria-labelledby="category-cards-women-tab">
            <div class="row g-4">
              <!-- Dresses Category -->
              <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="category-card">
                  <img src="{{asset('FashionStore')}}/assets/img/BAJU.PNG" alt="Women's Dresses" class="img-fluid" loading="lazy">
                  <a href="{{ route('customer.index') }}" class="category-link">
                    ATASAN <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>

              <!-- Tops Category -->
              <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="category-card">
                  <img src="{{asset('FashionStore')}}/assets/img/BAWAHAN.PNG" alt="Women's Tops" class="img-fluid" loading="lazy">
                  <a href="{{ route('customer.index') }}" class="category-link">
                    BAWAHAN <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>

              <!-- Accessories Category -->
              <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="400">
                <div class="category-card">
                  <img src="{{asset('FashionStore')}}/assets/img/TERUSAN.PNG" alt="Women's Accessories" class="img-fluid" loading="lazy">
                  <a href="{{ route('customer.index') }}" class="category-link">
                    TERUSAN <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Category Cards Section -->
@endsection
