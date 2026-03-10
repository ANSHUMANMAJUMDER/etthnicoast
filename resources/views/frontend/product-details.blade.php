@extends('frontend.layouts.master')
@section('body-class', 'no-navbar-scroll')
@section('contents')
@push('styles')
<style>
    #navbar
    a{ text-decoration:none; color:inherit; }
    button{ font-family: inherit; }
    img{ display:block; max-width:100%; }

    .container{
      max-width: var(--container);
      margin: 0 auto;
      padding: 0 clamp(1rem, 3vw, 3rem);
    }

    /* =========================
       PAGE
       ========================= */

    .breadcrumb{
      padding: 1.75rem 0 1rem;
      font-size: .85rem;
      color: var(--muted);
    }
    .breadcrumb a{ color: var(--muted); }
    .breadcrumb a:hover{ color: var(--primary-blue); }

    .product-wrap{
      display:grid;
      grid-template-columns: 1.15fr 0.85fr;
      gap: 2.25rem;
      align-items:start;
      padding-bottom: 2.25rem;
    }

    /* LEFT GALLERY */
    .gallery{
      display:grid;
      grid-template-columns: 92px 1fr;
      gap: 1.25rem;
      align-items:start;
      min-width: 0;
    }
    .thumbs{
      display:flex;
      flex-direction:column;
      gap: 12px;
      position: sticky;
      top: 160px;
      height: max-content;
    }
    .thumb{
      width: 92px;
      height: 92px;
      border: 1px solid var(--border);
      background:#f7f7f7;
      cursor:pointer;
      overflow:hidden;
      transition: .25s ease;
      position:relative;
    }
    .thumb img{ width:100%; height:100%; object-fit:cover; }
    .thumb.active{
      border-color: var(--primary-blue);
      box-shadow: 0 0 0 2px rgba(7,32,63,0.15);
    }
   .main-media{
  border: 1px solid var(--border);
  background:#f7f7f7;
  overflow:hidden;
  position: relative;
  aspect-ratio: 4/5;
}
.main-media .badge{
  position:absolute;
  top:16px; left:16px;
  background: var(--primary-blue);
  color: var(--white);
  padding: 6px 12px;
  font-size:.7rem;
  letter-spacing:1px;
  text-transform:uppercase;
  z-index:2;
}
.main-media img{
  width:100%;
  height: 100%;
  object-fit: cover;
  transition: transform .5s ease;
}
.main-media:hover img{ transform: scale(1.03); }

    /* RIGHT INFO */
    .info{
      position: sticky;
      top: 150px;
      height: max-content;
      border-left: 1px solid rgba(7,32,63,0.06);
      padding-left: 1.25rem;
    }

    .title{
      font-family: var(--font-primary);
      font-size: 2rem;
      font-weight: 600;
      color: var(--primary-blue);
      letter-spacing: 1px;
      line-height: 1.15;
      margin-bottom: .75rem;
    }

    .meta-row{
      display:flex;
      align-items:center;
      justify-content: space-between;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .rating{
      display:flex;
      align-items:center;
      gap: 8px;
      font-size: .9rem;
      color: var(--muted);
    }
    .rating .stars{ color:#f39c12; }
    .pill{
      display:inline-flex;
      align-items:center;
      gap: 8px;
      padding: 6px 10px;
      border: 1px solid var(--border);
      background: var(--white);
      font-size: .8rem;
      color: var(--primary-blue);
      letter-spacing: .5px;
      white-space: nowrap;
    }
    .pill strong{ color: var(--primary-blue); }

    .price-area{
      display:flex;
      align-items:baseline;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 10px;
    }
    .price{
      font-size: 1.6rem;
      font-weight: 800;
      color: var(--primary-blue);
    }
    .price.strikethrough{
      text-decoration: line-through;
      color: rgba(2,0,13,0.45);
      font-size: 1.4rem;
    }
    .price.discounted{
      color: #d32f2f;
    }
    .mrp{
      font-size: 1rem;
      color: rgba(2,0,13,0.45);
      text-decoration: line-through;
    }
    .discount{
      background: var(--secondary-peach);
      color: var(--primary-blue);
      font-size: .75rem;
      font-weight: 800;
      padding: 3px 8px;
      letter-spacing: .5px;
    }
    .subtext{
      font-size: .85rem;
      color: var(--muted);
      margin-bottom: 14px;
    }
.offer-box {
  border: 1px dashed rgba(7,32,63,0.25);
  padding: 12px;
  margin-bottom: 14px;
  background: linear-gradient(
    135deg,
    rgba(255, 248, 240, 0.9),
    rgba(235, 222, 212, 0.6)
  );
  border-radius: 8px;
}




    .offer-box .row{
      display:flex;
      justify-content: space-between;
      gap: 10px;
      flex-wrap: wrap;
      align-items:center;
      font-size: .85rem;
      color: rgba(2,0,13,0.72);
    }
    .coupon{
      display:inline-flex;
      gap: 8px;
      align-items:center;
      background: var(--white);
      border: 1px solid var(--border);
      padding: 6px 10px;
      font-weight: 700;
      color: var(--primary-blue);
      letter-spacing: .8px;
      text-transform: uppercase;
      font-size: .78rem;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .coupon:hover{
      background: var(--primary-blue);
      color: var(--white);
    }
    .coupon.applied{
      background: #4caf50;
      color: var(--white);
      border-color: #4caf50;
    }

    .option-block{
      padding: 14px 0;
      border-top: 1px solid rgba(7,32,63,0.08);
    }
    .opt-head{
      display:flex;
      justify-content: space-between;
      align-items:center;
      gap: 1rem;
      margin-bottom: 10px;
    }
    .opt-head .label{
      font-size: .85rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: rgba(2,0,13,0.75);
      font-weight: 700;
    }
    .opt-head .hint{
      font-size: .8rem;
      color: rgba(2,0,13,0.55);
    }

    .swatches{
      display:flex;
      gap: 10px;
      flex-wrap: wrap;
    }
    .swatch{
      width: 22px;
      height: 22px;
      border-radius: 999px;
      border: 1px solid rgba(7,32,63,0.25);
      cursor:pointer;
      position: relative;
      transition: .2s ease;
    }
   
    .swatch-more-btn{
  width: 22px;
  height: 22px;
  border-radius: 999px;
  border: 1px solid rgba(7,32,63,0.25);
  background: var(--white);
  cursor:pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: .7rem;
  color: var(--primary-blue);
  transition: .2s ease;
}
.swatch-more-btn:hover{
  border-color: var(--primary-blue);
  background: rgba(7,32,63,0.05);
}
.swatch-more-btn.hidden{
  display: none;
}

 .swatch.active{
      outline: 2px solid var(--primary-blue);
      outline-offset: 2px;
    }

    .chips{
      display:flex;
      gap: 10px;
      flex-wrap: wrap;
    }
    .chip{
      border: 1px solid rgba(7,32,63,0.22);
      background: var(--white);
      padding: 10px 12px;
      cursor:pointer;
      font-size: .85rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      transition: .25s ease;
      min-width: 98px;
      text-align:center;
    }
    .chip.active{
      background: var(--secondary-grey);
    color: #f8e3d2;
    border-color: var(--secondary-grey);
    }

    .size-grid{
      display:flex;
      gap: 10px;
      flex-wrap: wrap;
    }
    .size{
      min-width: 64px;
      padding: 10px 10px;
      border: 1px solid rgba(7,32,63,0.22);
      background: var(--white);
      cursor:pointer;
      font-size: .85rem;
      transition: .25s ease;
      text-align:center;
    }
    .size.active{
      border-color: var(--primary-blue);
      box-shadow: 0 0 0 2px rgba(7,32,63,0.12);
    }

   .cta-row{
  display:grid;
  grid-template-columns: 1fr 1fr 48px 48px;
  gap: 10px;
  margin-top: 12px;
}
    .btn-primary{
      padding: .95rem 1rem;
      border: 1px solid var(--primary-blue);
      background: var(--primary-blue);
      color: var(--white);
      cursor:pointer;
      font-size: .85rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      transition: .25s ease;
    }

    .btn-primary:hover{ filter: brightness(0.95); }
    .btn-secondary{
  padding: .95rem 1rem;
  border: 1px solid var(--primary-blue);
  background: var(--white);
  color: var(--primary-blue);
  cursor:pointer;
  font-size: .85rem;
  letter-spacing: 1px;
  text-transform: uppercase;
  transition: .25s ease;
}
.btn-secondary:hover{ 
  background: var(--primary-blue);
  color: var(--white);
}

    .icon-btn{
      border: 1px solid rgba(7,32,63,0.22);
      background: var(--white);
      cursor:pointer;
      font-size: 1rem;
      transition: .25s ease;
      display:flex;
      align-items:center;
      justify-content:center;
    }
    .icon-btn:hover{
      border-color: var(--primary-blue);
      color: var(--primary-blue);
    }

    .pin-row{
      display:flex;
      gap: 10px;
      margin-top: 10px;
      align-items:center;
    }
    .pin-row input{
      flex:1;
      padding: 10px 12px;
      border: 1px solid rgba(7,32,63,0.22);
      font-size: .85rem;
      outline:none;
    }
    .pin-row button{
      padding: 10px 14px;
      border: 1px solid var(--primary-blue);
      background: var(--primary-blue);
      color: var(--white);
      cursor:pointer;
      font-size: .82rem;
      letter-spacing: 1px;
      text-transform: uppercase;
    }
    .pin-status{
      margin-top: 8px;
      font-size: .82rem;
      color: rgba(2,0,13,0.7);
    }

    .usp-row{
      display:grid;
      grid-template-columns: 1fr;
      gap: 10px;
      margin-top: 12px;
    }
    .usp{
      border: 1px solid rgba(7,32,63,0.1);
      padding: 10px 12px;
      display:flex;
      gap: 10px;
      align-items:flex-start;
      background: rgba(235,222,212,0.18);
      font-size: .82rem;
      color: rgba(2,0,13,0.75);
    }
    .usp i{ color: var(--primary-blue); margin-top: 2px; }

    /* Accordion (Description / Specification / More Info) */
    .accordion{
      margin-top: 14px;
      border-top: 1px solid rgba(7,32,63,0.08);
    }
    .acc-item{
      border-bottom: 1px solid rgba(7,32,63,0.08);
    }
    .acc-btn{
      width:100%;
      padding: 14px 0;
      background: transparent;
      border:none;
      cursor:pointer;
      display:flex;
      justify-content: space-between;
      align-items:center;
      gap: 10px;
      text-align:left;
    }
    .acc-btn .t{
      font-size: .9rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: rgba(2,0,13,0.85);
      font-weight: 700;
    }
    .acc-btn i{
      transition: transform .25s ease;
      color: var(--primary-blue);
    }
    .acc-item.active .acc-btn i{ transform: rotate(180deg); }
    .acc-body{
      display:none;
      padding: 0 0 14px;
      color: rgba(2,0,13,0.72);
      font-size: .9rem;
      line-height: 1.6;
    }
    .acc-item.active .acc-body{ display:block; }

    /* =========================
       COMPLETE THE LOOK
       ========================= */
    .section{
      padding: 2.25rem 0;
    }
    .section-title{
      text-align:center;
      font-family: var(--font-primary);
      color: var(--primary-blue);
      font-size: 1.6rem;
      letter-spacing: 2px;
      text-transform: uppercase;
      margin-bottom: 1.25rem;
      font-weight: 500;
    }
    .look-wrap{
      background: rgba(235,222,212,0.6);
      border: 1px solid rgba(7,32,63,0.08);
      padding: 1.5rem;
    }
    /* .look-grid{
      display:grid;
      grid-template-columns: repeat(3, minmax(0,1fr));
      gap: 1.25rem;
      align-items:center;
      max-width: 900px;
      margin: 0 auto;
    } */

    .look-grid{
  display:grid;
  grid-template-columns: 1fr auto 1fr auto 1fr;  /* Changed from: repeat(3, minmax(0,1fr)) */
  gap: 1.25rem;
  align-items:center;
  max-width: 1100px;  /* Changed from: 900px */
  margin: 0 auto;
}
    .look-card{
      border: 1px solid rgba(7,32,63,0.12);
      background: var(--white);
      overflow:hidden;
    }
    .look-img{
      aspect-ratio: 4/5;
      background:#f7f7f7;
    }
    .look-img img{ width:100%; height:100%; object-fit:cover; }
    .look-bottom{
      padding: 10px 12px;
      display:flex;
      justify-content: space-between;
      align-items:center;
      gap: 10px;
      font-size: .9rem;
    }
    .look-plus{
      display:flex;
      justify-content:center;
      align-items:center;
      font-size: 1.25rem;
      color: var(--primary-blue);
      font-weight: 800;
    }
    /* .buy-all{
      max-width: 900px;
      margin: 1.25rem auto 0;
      display:flex;
      justify-content:center;
      gap: 12px;
      flex-wrap: wrap;
      align-items:center;
    } */

    .buy-all{
  max-width: 1100px;  /* Changed from: 900px */
  margin: 1.25rem auto 0;
  display:flex;
  justify-content:center;
  gap: 12px;
  flex-wrap: wrap;
  align-items:center;
}
    .buy-all .label{
      font-size:.85rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: rgba(2,0,13,0.75);
      font-weight: 700;
    }

    /* =========================
       SIMILAR ITEMS
       ========================= */
    .similar-grid{
      display:grid;
      grid-template-columns: repeat(5, minmax(0,1fr));
      gap: 1.25rem;
    }
    .mini-card{
      border: 1px solid rgba(7,32,63,0.1);
      background: var(--white);
      overflow:hidden;
      cursor:pointer;
      transition: .25s ease;
    }
    .mini-card:hover{
      transform: translateY(-4px);
      box-shadow: var(--shadow);
    }
    .mini-img{
      height: 220px;
      background:#f7f7f7;
    }
    .mini-img img{ width:100%; height:100%; object-fit:cover; }
    .mini-info{
      padding: 10px 12px;
      display:flex;
      justify-content: space-between;
      gap: 10px;
      align-items:center;
    }
    .mini-name{
      font-family: var(--font-primary);
      color: var(--primary-blue);
      font-size: 1rem;
      line-height: 1.15;
    }
    .mini-price{
      font-weight: 800;
      color: var(--primary-blue);
      font-size: .95rem;
      white-space: nowrap;
    }

    /* =========================
       REVIEWS
       ========================= */
    .reviews-wrap{
      max-width: 1100px;
      margin: 0 auto;
      border-top: 1px solid rgba(7,32,63,0.08);
      padding-top: 1.75rem;
    }
    .review-head{
      display:flex;
      justify-content: space-between;
      align-items:flex-start;
      gap: 1rem;
      flex-wrap: wrap;
      margin-bottom: 1.25rem;
    }
    .review-score{
      display:flex;
      gap: 14px;
      align-items:center;
    }
    .score{
      font-size: 2.1rem;
      font-weight: 900;
      color: var(--primary-blue);
      line-height: 1;
    }
    .score-meta{
      color: rgba(2,0,13,0.7);
      font-size: .9rem;
    }
    .review-btn{
      padding: .8rem 1rem;
      border: 1px solid var(--primary-blue);
      background: transparent;
      color: var(--primary-blue);
      cursor:pointer;
      letter-spacing:1px;
      text-transform: uppercase;
      font-size: .85rem;
      transition: .25s ease;
    }
    .review-btn:hover{
      background: var(--primary-blue);
      color: var(--white);
    }

    .review-list{
      display:grid;
      grid-template-columns: repeat(2, minmax(0,1fr));
      gap: 1.25rem;
    }
    .review-card{
      border: 1px solid rgba(7,32,63,0.1);
      padding: 14px;
      background: var(--white);
    }
    .review-top{
      display:flex;
      justify-content: space-between;
      gap: 10px;
      margin-bottom: 10px;
      align-items:center;
    }
    .review-name{
      font-weight: 800;
      color: rgba(2,0,13,0.8);
      font-size: .92rem;
    }
    .review-date{
      font-size: .82rem;
      color: rgba(2,0,13,0.55);
    }
    .review-stars{ color:#f39c12; font-size: .9rem; margin-bottom: 8px; }
    .review-text{
      color: rgba(2,0,13,0.72);
      font-size: .92rem;
      line-height: 1.55;
    }

    /* ---- Review Modal ---- */
    .modal{
      position: fixed;
      inset: 0;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 16px;
      z-index: 10000;
    }
    .modal.active{ display:flex; }
    .modal .backdrop{
      position:absolute;
      inset:0;
      background: rgba(2,0,13,0.55);
    }
    .modal-card{
      position: relative;
      width: min(720px, 100%);
      background: var(--white);
      border: 1px solid rgba(7,32,63,0.12);
      box-shadow: 0 20px 50px rgba(7,32,63,0.18);
      border-radius: 0px; /* keep same clean style */
      overflow: hidden;
    }
    .modal-head{
      padding: 14px 16px;
      border-bottom: 1px solid rgba(7,32,63,0.08);
      display:flex;
      align-items:center;
      justify-content: space-between;
      gap: 10px;
      background: rgba(235,222,212,0.35);
    }
    .modal-title{
      font-family: var(--font-primary);
      font-weight: 700;
      color: var(--primary-blue);
      letter-spacing: 1px;
      text-transform: uppercase;
      font-size: 1rem;
    }
    .modal-close{
      width: 40px;
      height: 40px;
      border: 1px solid rgba(7,32,63,0.18);
      background: var(--white);
      cursor:pointer;
      display:flex;
      align-items:center;
      justify-content:center;
      transition: .2s ease;
    }
    .modal-close:hover{
      border-color: var(--primary-blue);
      color: var(--primary-blue);
    }
    .modal-body{
      padding: 16px;
    }

    .form-grid{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }
    .field{
      display:flex;
      flex-direction:column;
      gap: 6px;
    }
    .field.full{ grid-column: 1 / -1; }
    .field label{
      font-size: .82rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: rgba(2,0,13,0.75);
      font-weight: 700;
    }
    .field input,
    .field textarea{
      border: 1px solid rgba(7,32,63,0.22);
      padding: 10px 12px;
      font-size: .9rem;
      outline: none;
      background: var(--white);
    }
    .field textarea{
      resize: vertical;
      min-height: 110px;
      line-height: 1.5;
    }
    .helper-row{
      display:flex;
      justify-content: space-between;
      gap: 10px;
      margin-top: 10px;
      flex-wrap: wrap;
      align-items: center;
    }
    .error-text{
      font-size: .85rem;
      color: #e74c3c;
      display:none;
    }
    .error-text.show{ display:block; }

    .rating-picker{
      display:flex;
      align-items:center;
      gap: 10px;
      flex-wrap: wrap;
      padding: 10px 0 0;
    }
    .rating-picker .label{
      font-size: .82rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: rgba(2,0,13,0.75);
      font-weight: 700;
      margin-right: 6px;
    }
    .stars-input{
      display:flex;
      gap: 6px;
      align-items:center;
      user-select:none;
    }
    .star-btn{
      width: 40px;
      height: 40px;
      border: 1px solid rgba(7,32,63,0.18);
      background: var(--white);
      cursor:pointer;
      display:flex;
      align-items:center;
      justify-content:center;
      transition: .2s ease;
      color: rgba(2,0,13,0.35);
      font-size: 1.05rem;
    }
    .star-btn:hover{ border-color: var(--primary-blue); }
    .star-btn.active{
      color: #f39c12;
      border-color: rgba(243,156,18,0.45);
      box-shadow: 0 0 0 2px rgba(243,156,18,0.12);
    }
    .rating-value{
      font-weight: 800;
      color: var(--primary-blue);
      font-size: .95rem;
      letter-spacing: .5px;
    }

    .modal-actions{
      padding: 14px 16px;
      border-top: 1px solid rgba(7,32,63,0.08);
      display:flex;
      justify-content: flex-end;
      gap: 10px;
      background: rgba(235,222,212,0.15);
      flex-wrap: wrap;
    }
    .btn-ghost{
      padding: .85rem 1rem;
      border: 1px solid rgba(7,32,63,0.22);
      background: var(--white);
      cursor:pointer;
      font-size: .85rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      transition: .25s ease;
      color: rgba(2,0,13,0.8);
    }
    .btn-ghost:hover{
      border-color: var(--primary-blue);
      color: var(--primary-blue);
    }

    .toast{
      position: fixed;
      right: 16px;
      bottom: 16px;
      background: var(--primary-blue);
      color: var(--white);
      padding: 12px 14px;
      font-size: .9rem;
      letter-spacing: .5px;
      box-shadow: 0 12px 25px rgba(7,32,63,0.25);
      transform: translateY(18px);
      opacity: 0;
      pointer-events:none;
      transition: .25s ease;
      z-index: 3000;
    }
    .toast.show{
      opacity: 1;
      transform: translateY(0);
    }

    /* =========================
       STICKY CTA (mobile)
       ========================= */
    .sticky-cta{
      display:none;
      position: fixed;
      left:0; right:0; bottom:0;
      background: var(--white);
      border-top: 1px solid rgba(7,32,63,0.12);
      padding: 10px 12px;
      z-index: 1200;
    }
    .sticky-cta .row{
      max-width: var(--container);
      margin: 0 auto;
      display:flex;
      gap: 10px;
      align-items:center;
      padding: 0 clamp(1rem, 3vw, 3rem);
    }
    .sticky-cta .mini{
      flex:1;
      min-width:0;
    }
    .sticky-cta .mini .n{
      font-family: var(--font-primary);
      color: var(--primary-blue);
      font-weight: 600;
      font-size: 1rem;
      white-space: nowrap;
      overflow:hidden;
      text-overflow: ellipsis;
    }
    .sticky-cta .mini .p{
      font-weight: 900;
      color: var(--primary-blue);
      font-size: 1.05rem;
    }

    /* =========================
       RESPONSIVE
       ========================= */
    @media (max-width: 1200px){
      /* .main-media img{ height: 100%; } */
      .similar-grid{ grid-template-columns: repeat(4, minmax(0,1fr)); }
    }

    @media (max-width: 992px){
      .product-wrap{ grid-template-columns: 1fr; }
      .info{
        position: static;
        border-left: none;
        padding-left: 0;
      }
      .thumbs{
        position: static;
        flex-direction: row;
        overflow-x: auto;
        padding-bottom: 6px;
      }
      .gallery{
        grid-template-columns: 1fr;
      }
      .thumb{ width: 84px; height: 84px; flex: 0 0 auto; }
   /* .main-media img{ height: 340px; } */
      .similar-grid{ grid-template-columns: repeat(3, minmax(0,1fr)); }
      .review-list{ grid-template-columns: 1fr; }
      .sticky-cta{ display:block; }
      .form-grid{ grid-template-columns: 1fr; }
    }

    @media (max-width: 768px){
      .look-grid{ grid-template-columns: 1fr; }
      .look-plus{ display:none; }
      .similar-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); }
      .usp-row{ grid-template-columns: 1fr; }
      .cta-row{ grid-template-columns: 1fr 1fr 48px 48px; }
    }


/* TABLET - 992px breakpoint */
@media (max-width: 992px){
  .look-grid{ 
    grid-template-columns: 1fr auto 1fr auto 1fr;  /* Added this line */
    gap: 0.75rem;  /* Added this line - reduced gap for smaller screens */
  }
}

/* MOBILE - 768px breakpoint (already existed, no changes needed) */
@media (max-width: 768px){
  .look-grid{ grid-template-columns: 1fr; }
  .look-plus{ display:none; }
}

    @media (max-width: 480px){
      .main-media img{ height: 340px; }
      .title{ font-size: 1.6rem; }
      .similar-grid{ gap: .9rem; }
      .mini-img{ height: 180px; }
      .cta-row{ 
  grid-template-columns: 1fr 1fr;
}
.cta-row .btn-primary,
.cta-row .btn-secondary{
  grid-column: 1 / -1;
}
    }

    .rating-icons i {
  color: #ddd;
}

.rating-icons i.active {
  color: #ff9800;
}

.rating-icons span {
  margin-left: 6px;
  font-size: 13px;
}

  </style>
 @endpush


</head>

<body>
  <div class="overlay" id="overlay"></div>

  <main class="container" style="padding-top: 150px">
    <div class="breadcrumb">
      <a href="/">Home</a> / <a href="/shop">Shop</a> / <strong>Product Details</strong>
    </div>
 {{-- @php
     dd($product)
 @endphp --}}
    <!-- TOP SECTION -->
    <section class="product-wrap">
      <!-- LEFT: Gallery -->
      <div class="gallery">
     <div class="thumbs" id="thumbs">
    @foreach($product->images as $index => $image)
        <div class="thumb {{ $index == 0 ? 'active' : '' }}"
             data-src="{{ $image->url }}">
             
            <img src="{{ $image->url }}"
                 alt="thumb {{ $index + 1 }}">
        </div>
    @endforeach
</div>

        <div class="main-media">
          <div class="badge">New</div>
     <img id="mainImage" src="{{ $product->main_image }}" alt="Product main" />

            

          </div>
      </div>

      <!-- RIGHT: Info -->
      <aside class="info">
        <h1 class="title" id="productTitle">{{ $product->base_name }}</h1>

        <div class="meta-row">
          <div class="rating" aria-label="Average rating">
            <!-- <span class="stars" id="avgStars">⭐⭐⭐⭐⭐</span>
            <span id="avgRatingText">4.8</span> -->
            <div class="rating-icons">
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star"></i>
  <span>4.0</span>
</div>
            <span>(<span id="reviewCountText">190</span> reviews)</span>
          </div>
          <div class="pill"><i class="fa-solid fa-truck"></i> <strong>Free Shipping</strong></div>
        </div>

        <div class="price-area">
          <div class="price" id="productPrice">{{ $product->base_price }}</div>
          <div class="price discounted" id="discountedPrice" style="display:none;"></div>
        </div>
        <!-- <div class="subtext">MRP inclusive of all taxes • Best Price <strong>₹21,999</strong></div> -->

        <div class="offer-box">
          <div class="row">
            <div><strong>Flat 10% Off</strong> + prepaid discount</div>
            <button class="coupon" id="couponBtn" type="button"><i class="fa-solid fa-tag"></i> ETTH10</button>
          </div>
        </div>

        <!-- Available in / metal names (like your wireframe right side) -->
        <div class="option-block">
          <div class="opt-head">
            <div class="label">Finish</div>
          </div>
          <div class="chips" id="metalChips">
            {{-- <button class="chip active" type="button">Rhodium </button>
            <button class="chip" type="button">Gold</button>
            <button class="chip" type="button">Rose Gold</button>
            <button class="chip" type="button">Oxidised </button> --}}

              @foreach($product->variants as $variant)
                  <button class="chip" type="button">{{ $variant->finish }}</button>
              @endforeach
          </div>
        </div>

        <!-- Color / finish dots -->
        <div class="option-block">
          <div class="opt-head">
            <div class="label">Available In</div>
            
          </div>
          <div class="swatches" id="swatches">
  <div class="swatch active" data-color="emerald" style="background:#50C878" title="Green Emerald"></div>
  <div class="swatch" data-color="ruby" style="background:#E0115F" title="Ruby"></div>
  <div class="swatch" data-color="turquoise" style="background:#40E0D0" title="Turquoise"></div>
  <div class="swatch" data-color="coral" style="background:#FF7F50" title="Coral"></div>
  <div class="swatch" data-color="black-stone" style="background:#1C1C1C" title="Black Stone"></div>
  <div class="swatch" data-color="pearl" style="background:#F0EAD6" title="Pearl"></div>
   <button class="swatch-more-btn" id="swatchMoreBtn" type="button" title="See more colors">
    <i class="fa-solid fa-plus"></i>
  </button>
</div>
        </div>

        <!-- Single / Pair toggle -->
        <div class="option-block">
          <div class="opt-head">
            <div class="label">Select Type</div>
         
          </div>
          <div class="chips" id="typeChips">
            <button class="chip" type="button">Single</button>
            <button class="chip" type="button">Pair</button>
          </div>
        </div>

        <!-- Size -->
        <div class="option-block">
          <div class="opt-head">
            <div class="label">Size</div>
            
          </div>
          <div class="size-grid" id="sizes">
            <button class="size active" type="button">6</button>
            <button class="size" type="button">7</button>
            <button class="size" type="button">8</button>
            <button class="size" type="button">9</button>
          </div>
        </div>

        <!-- CTAs -->
      <div class="cta-row">
  {{-- <button class="btn-primary" id="addToCartBtn">Add to Cart</button> --}}
  <button 
  class="btn-primary" 
  id="addToCartBtn"
  data-add-url="{{ route('cart.store') }}"
  data-remove-url="{{ route('cart.destroy') }}"
  data-product-id="{{ $product->id }}"
  {{-- data-variant-id="{{ }}" --}}
>
  Add to Cart
</button>
  <button class="btn-secondary" id="buyNowBtn">Buy Now</button>
  <button class="icon-btn" id="wishBtn" aria-label="Wishlist"><i class="fa-regular fa-heart"></i></button>
  <button class="icon-btn" aria-label="Share"><i class="fa-solid fa-share-nodes"></i></button>
</div>

        <!-- Delivery / pincode -->
        <div class="option-block" style="padding-top:12px;">
          <div class="opt-head" style="margin-bottom:8px;">
            <div class="label">Estimated Delivery Time</div>
            <div class="hint"></div>
          </div>
          <div class="pin-row">
            <input id="pincode" type="text" inputmode="numeric" placeholder="Enter 6 digit pincode" maxlength="6" />
            <button id="checkPin">Check</button>
          </div>
          <div class="pin-status" id="pinStatus">Enter pincode to check delivery estimate.</div>

      <div class="usp-row">
            <div class="usp"><i class="fa-solid fa-rotate-left"></i> 30 days easy exchange</div>
            <div class="usp"><i class="fa-solid fa-spray-can-sparkles"></i> Free lifetime plating</div>
            <div class="usp"><i class="fa-solid fa-clock"></i> 9 to 5 customer support</div>
          </div>
        </div>

        <!-- Accordions -->
        <div class="accordion" id="accordion">
          <div class="acc-item active">
            <button class="acc-btn" type="button">
              <span class="t">Description</span>
              <i class="fa-solid fa-chevron-down"></i>
            </button>
            <div class="acc-body">
              A timeless solitaire ring crafted for everyday elegance. Designed with premium finish, comfortable fit,
              and a refined silhouette that pairs beautifully with any look.
            </div>
          </div>

          <div class="acc-item">
            <button class="acc-btn" type="button">
              <span class="t">Specification</span>
              <i class="fa-solid fa-chevron-down"></i>
            </button>
            <div class="acc-body">
              <ul style="padding-left:18px; line-height:1.8;">
                <li>Material: 925 Sterling Silver (base)</li>
                <li>Finish: High-polish • Anti-tarnish coating</li>
                <li>Stone: AAA Zircon (simulated diamond)</li>
                <li>Weight: Approx. 2.8g</li>
              </ul>
            </div>
          </div>

          <div class="acc-item">
            <button class="acc-btn" type="button">
              <span class="t">More Info</span>
              <i class="fa-solid fa-chevron-down"></i>
            </button>
            <div class="acc-body">
              Exchange policy and care instructions:
              keep away from perfume/water for long-lasting shine. Store in a dry pouch after use.
            </div>
          </div>
        </div>
      </aside>
    </section>

    <!-- COMPLETE THE LOOK -->
    {{-- <section class="section">
      <h2 class="section-title">Complete the look</h2>
      <div class="look-wrap">
        <div class="look-grid">
          <div class="look-card">
            <div class="look-img">
              <img src="https://images.unsplash.com/photo-1611652022419-a9419f74343d?w=1200&q=80" alt="Look item 1">
            </div>
            <div class="look-bottom">
              <span>Statement Ring</span>
              <strong>₹15,999</strong>
            </div>
          </div>

          <div class="look-plus">+</div>

          <div class="look-card">
            <div class="look-img">
              <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=1200&q=80" alt="Look item 2">
            </div>
            <div class="look-bottom">
              <span>Drop Earrings</span>
              <strong>₹12,999</strong>
            </div>
          </div>

          <div class="look-plus">+</div>

          <div class="look-card">
            <div class="look-img">
              <img src="https://images.unsplash.com/photo-1599643477877-530eb83abc8e?w=1200&q=80" alt="Look item 3">
            </div>
            <div class="look-bottom">
              <span>Heart Pendant</span>
              <strong>₹9,999</strong>
            </div>
          </div>
        </div>

        <div class="buy-all">
          <span class="label">Buy all 3:</span>
          <strong style="color:var(--primary-blue); font-size:1.15rem;">₹38,997</strong>
          <button class="btn-primary" type="button" style="padding:.85rem 1.1rem;">Add Set to Cart</button>
        </div>
      </div>
    </section> --}}
{{-- Complete the Look Section --}}
@if($product->completeLookProducts->isNotEmpty())
<section class="section">
  <h2 class="section-title">Complete the look</h2>
  <div class="look-wrap">
    <div class="look-grid">
      @foreach($product->completeLookProducts as $index => $lookProduct)

        @if($index > 0)
          <div class="look-plus">+</div>
        @endif

        <div class="look-card">
          <div class="look-img">
            @php
              $img = $lookProduct->images->first();
            @endphp
            @if($img)
              <img src="{{ asset('public/storage/' . $img->image) }}" alt="{{ $lookProduct->name }}">
            @else
              <img src="https://via.placeholder.com/400x400?text=No+Image" alt="{{ $lookProduct->name }}">
            @endif
          </div>
          <div class="look-bottom">
            <span>{{ $lookProduct->base_name }}</span>
            <strong>₹{{ number_format($lookProduct->base_price, 0, '.', ',') }}</strong>
          </div>
        </div>

      @endforeach
    </div>

    @php
      $totalCost = $product->completeLookProducts->sum('base_price');
    @endphp

    <div class="buy-all">
      <span class="label">Buy all {{ $product->completeLookProducts->count() }}:</span>
      <strong style="color:var(--primary-blue); font-size:1.15rem;">
        ₹{{ number_format($totalCost, 0, '.', ',') }}
      </strong>
      <button class="btn-primary" type="button" style="padding:.85rem 1.1rem;">
        Add Set to Cart
      </button>
    </div>
  </div>
</section>
@endif

    <!-- SIMILAR ITEMS -->
    {{-- <section class="section" style="padding-top: 0;">
      <h2 class="section-title">Similar items</h2>

      <div class="similar-grid">
        <div class="mini-card">
          <div class="mini-img"><img src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=1200&q=80" alt=""></div>
          <div class="mini-info">
            <div class="mini-name">Bridal Set</div>
            <div class="mini-price">₹45,999</div>
          </div>
        </div>
        <div class="mini-card">
          <div class="mini-img"><img src="https://images.unsplash.com/photo-1617038260897-41a1f14a8ca0?w=1200&q=80" alt=""></div>
          <div class="mini-info">
            <div class="mini-name">Anklet</div>
            <div class="mini-price">₹6,499</div>
          </div>
        </div>
        <div class="mini-card">
          <div class="mini-img"><img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=1200&q=80" alt=""></div>
          <div class="mini-info">
            <div class="mini-name">Pendant</div>
            <div class="mini-price">₹18,499</div>
          </div>
        </div>
        <div class="mini-card">
          <div class="mini-img"><img src="https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=1200&q=80" alt=""></div>
          <div class="mini-info">
            <div class="mini-name">Bracelet</div>
            <div class="mini-price">₹8,999</div>
          </div>
        </div>
        <div class="mini-card">
          <div class="mini-img"><img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=1200&q=80" alt=""></div>
          <div class="mini-info">
            <div class="mini-name">Solitaire</div>
            <div class="mini-price">₹24,999</div>
          </div>
        </div>
      </div>
    </section> --}}

    {{-- Similar Items Section --}}
@if($product->similarProducts->isNotEmpty())
<section class="section" style="padding-top: 0;">
  <h2 class="section-title">Similar items</h2>

  <div class="similar-grid">
    @foreach($product->similarProducts as $similar)
      <a href="{{ route('frontend.product-details', $similar->id) }}" style="text-decoration:none; color:inherit;">
  <div class="mini-card">
    <div class="mini-img">
      @php $img = $similar->images->first(); @endphp
      @if($img)
        <img src="{{ asset('public/storage/' . $img->image) }}" alt="{{ $similar->name }}">
      @else
        <img src="https://via.placeholder.com/400x400?text=No+Image" alt="{{ $similar->name }}">
      @endif
    </div>
    <div class="mini-info">
      <div class="mini-name">{{ $similar->base_name }}</div>
      <div class="mini-price">₹{{ number_format($similar->base_price, 0, '.', ',') }}</div>
    </div>
  </div>
</a>
    @endforeach
  </div>
</section>
@endif

    <!-- CUSTOMER REVIEWS -->
    {{-- <section class="section" style="padding-top: 0;">
      <h2 class="section-title">Customer review</h2>

      <div class="reviews-wrap">
        <div class="review-head">
          <div class="review-score">
            <div class="score" id="scoreBig">4.0</div>
            <div class="score-meta">
              <div style="color:#f39c12; font-size:1rem; margin-bottom:6px;" id="scoreStars">
                <div class="rating-icons">
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star"></i>

</div>
              </div>
              Based on <strong id="basedOn">190</strong> reviews
            </div>
          </div>
          <button class="review-btn" id="openReviewModalBtn" type="button">Write a review</button>
        </div>

        <!-- Review list (JS will manage) -->
        <div class="review-list" id="reviewList">
          <div class="review-card">
            <div class="review-top">
              <div class="review-name">Ananya</div>
              <div class="review-date">12 Jan 2026</div>
            </div>
            <div class="review-stars">
              <div class="rating-icons">
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star"></i>

</div>
            </div>
            <div class="review-text">
              Beautiful finish and looks premium. Delivery was quick and packaging was lovely.
            </div>
          </div>

          <div class="review-card">
            <div class="review-top">
              <div class="review-name">Ritvik</div>
              <div class="review-date">04 Jan 2026</div>
            </div>
            <div class="review-stars">
                   <div class="rating-icons">
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>


</div>
            </div>
            <div class="review-text">
              Great value for the price. The stone sparkle is amazing. Size fits perfectly.
            </div>
          </div>

          <div class="review-card">
            <div class="review-top">
              <div class="review-name">Megha</div>
              <div class="review-date">28 Dec 2025</div>
            </div>
            <div class="review-stars">
                    <div class="rating-icons">
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
                    </div>
            </div>
            <div class="review-text">
              Minimal and classy. I wear it daily. No irritation and still shining after weeks.
            </div>
          </div>

          <div class="review-card">
            <div class="review-top">
              <div class="review-name">Sourav</div>
              <div class="review-date">10 Dec 2025</div>
            </div>
            <div class="review-stars">
                    <div class="rating-icons">
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
  <i class="fa fa-star active"></i>
            </div>
            <div class="review-text">
              Gifted it and she loved it. The quality feels great and the look is elegant.
            </div>
          </div>
        </div>
      </div>
    </section> --}}
  </main>

  <!-- Sticky CTA (mobile) -->
  <div class="sticky-cta" id="stickyCta">
    <div class="row">
      <div class="mini">
        <div class="n">Elegant Diamond Solitaire Ring</div>
        <div class="p">₹24,999</div>
      </div>
      <button class="btn-primary" id="stickyAddBtn" style="padding:.85rem 1rem;">Add to Cart</button>
      <button class="icon-btn" id="stickyWishBtn" aria-label="Wishlist" style="width:48px;height:48px;">
        <i class="fa-regular fa-heart"></i>
      </button>
    </div>
  </div>

  <!-- Review Modal -->
  {{-- <div class="modal" id="reviewModal" aria-hidden="true">
    <div class="backdrop" id="reviewBackdrop"></div>

    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="reviewModalTitle">
      <div class="modal-head">
        <div class="modal-title" id="reviewModalTitle">Write a review</div>
        <button class="modal-close" id="closeReviewModalBtn" type="button" aria-label="Close review modal">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <div class="modal-body">
        <div class="rating-picker">
          <div class="label">Your rating</div>
          <div class="stars-input" id="starsInput" aria-label="Select rating">
            <button class="star-btn" type="button" data-value="1" aria-label="1 star"><i class="fa-solid fa-star"></i></button>
            <button class="star-btn" type="button" data-value="2" aria-label="2 stars"><i class="fa-solid fa-star"></i></button>
            <button class="star-btn" type="button" data-value="3" aria-label="3 stars"><i class="fa-solid fa-star"></i></button>
            <button class="star-btn" type="button" data-value="4" aria-label="4 stars"><i class="fa-solid fa-star"></i></button>
            <button class="star-btn" type="button" data-value="5" aria-label="5 stars"><i class="fa-solid fa-star"></i></button>
          </div>
          <div class="rating-value" id="ratingValue">0/5</div>
        </div>

        <div class="helper-row" style="margin-top: 10px;">
          <div class="error-text" id="reviewError">Please fill all fields and select rating.</div>
        </div>

        <div class="form-grid" style="margin-top: 12px;">
          <div class="field">
            <label for="reviewName">Name</label>
            <input id="reviewName" type="text" placeholder="Your name" maxlength="40" />
          </div>

          <div class="field">
            <label for="reviewTitle">Title (optional)</label>
            <input id="reviewTitle" type="text" placeholder="Short headline" maxlength="60" />
          </div>

          <div class="field full">
            <label for="reviewMessage">Review</label>
            <textarea id="reviewMessage" placeholder="Share your experience..." maxlength="600"></textarea>
          </div>
          <input type="hidden" id="reviewProductId" value="{{ $product->id }}">
        </div>
      </div>

      <div class="modal-actions">
        <button class="btn-ghost" id="cancelReviewBtn" type="button">Cancel</button>
        <button class="btn-primary" id="submitReviewBtn" type="button">Submit Review</button>
      </div>
    </div>
  </div> --}}

  {{-- <div class="toast" id="toast">Review submitted ✓</div> --}}

@php
  $reviews     = $product->reviews;
  $totalReviews = $reviews->count();
  $avgRating   = $totalReviews > 0 ? round($reviews->avg('rating'), 1) : 0;
@endphp

<section class="section" style="padding-top: 0;">
  <h2 class="section-title">Customer review</h2>

  <div class="reviews-wrap">
    <div class="review-head">
      <div class="review-score">
        <div class="score" id="scoreBig">{{ $avgRating }}</div>
        <div class="score-meta">
          <div style="color:#f39c12; font-size:1rem; margin-bottom:6px;">
            <div class="rating-icons">
              @for($i = 1; $i <= 5; $i++)
                <i class="fa fa-star {{ $i <= round($avgRating) ? 'active' : '' }}"></i>
              @endfor
            </div>
          </div>
          Based on <strong id="basedOn">{{ $totalReviews }}</strong> {{ Str::plural('review', $totalReviews) }}
        </div>
      </div>
      <button class="review-btn" id="openReviewModalBtn" type="button">Write a review</button>
    </div>

    <div class="review-list" id="reviewList">
      @forelse($reviews as $review)
        <div class="review-card">
          <div class="review-top">
            <div class="review-name">{{ $review->name }}</div>
            <div class="review-date">{{ $review->created_at->format('d M Y') }}</div>
          </div>
          @if($review->title)
            <div class="review-title" style="font-size:0.9rem; font-weight:600; margin-bottom:4px;">
              {{ $review->title }}
            </div>
          @endif
          <div class="review-stars">
            <div class="rating-icons">
              @for($i = 1; $i <= 5; $i++)
                <i class="fa fa-star {{ $i <= $review->rating ? 'active' : '' }}"></i>
              @endfor
            </div>
          </div>
          <div class="review-text">{{ $review->message }}</div>
        </div>
      @empty
        <div class="review-empty" style="padding: 2rem 0; color: #888; text-align:center;">
          No reviews yet. Be the first to write one!
        </div>
      @endforelse
    </div>
  </div>
</section>


  <div class="modal" id="reviewModal" aria-hidden="true">
    <div class="backdrop" id="reviewBackdrop"></div>
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="reviewModalTitle">
      <div class="modal-head">
        <div class="modal-title" id="reviewModalTitle">Write a review</div>
        <button class="modal-close" id="closeReviewModalBtn" type="button" aria-label="Close review modal">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <div class="modal-body">

        {{-- Hidden fields --}}
        <input type="hidden" id="reviewProductId" value="{{ $product->id }}">

        <div class="rating-picker">
          <div class="label">Your rating</div>
          <div class="stars-input" id="starsInput" aria-label="Select rating">
            <button class="star-btn" type="button" data-value="1" aria-label="1 star"><i class="fa-solid fa-star"></i></button>
            <button class="star-btn" type="button" data-value="2" aria-label="2 stars"><i class="fa-solid fa-star"></i></button>
            <button class="star-btn" type="button" data-value="3" aria-label="3 stars"><i class="fa-solid fa-star"></i></button>
            <button class="star-btn" type="button" data-value="4" aria-label="4 stars"><i class="fa-solid fa-star"></i></button>
            <button class="star-btn" type="button" data-value="5" aria-label="5 stars"><i class="fa-solid fa-star"></i></button>
          </div>
          <div class="rating-value" id="ratingValue">0/5</div>
        </div>

        <div class="helper-row" style="margin-top: 10px;">
          <div class="error-text" id="reviewError" style="display:none;">Please fill all fields and select rating.</div>
        </div>

        <div class="form-grid" style="margin-top: 12px;">
          <div class="field">
            <label for="reviewName">Name</label>
            <input id="reviewName" type="text" placeholder="Your name" maxlength="40" />
          </div>
          <div class="field">
            <label for="reviewTitle">Title (optional)</label>
            <input id="reviewTitle" type="text" placeholder="Short headline" maxlength="60" />
          </div>
          <div class="field full">
            <label for="reviewMessage">Review</label>
            <textarea id="reviewMessage" placeholder="Share your experience..." maxlength="600"></textarea>
          </div>
        </div>

      </div>
      <div class="modal-actions">
        <button class="btn-ghost" id="cancelReviewBtn" type="button">Cancel</button>
        <button class="btn-primary" id="submitReviewBtn" type="button"
                data-url="{{ route('reviews.store') }}">
          Submit Review
        </button>
      </div>
    </div>
</div>

<div class="toast" id="toast"></div>
  
  @push('scripts')
  <script>
document.getElementById("navbar").classList.add("scrolled");
    // ===== Overlay helpers (used by review modal)
    const overlay = document.getElementById("overlay");
    function openOverlay(){ overlay.classList.add("active"); document.body.style.overflow="hidden"; }
    function closeOverlay(){ overlay.classList.remove("active"); document.body.style.overflow=""; }

    // ===== Gallery thumbs
    const thumbs = document.querySelectorAll(".thumb");
    const mainImage = document.getElementById("mainImage");

    thumbs.forEach(t=>{
      t.addEventListener("click", ()=>{
        thumbs.forEach(x=>x.classList.remove("active"));
        t.classList.add("active");
        const src = t.getAttribute("data-src");
        mainImage.src = src;
      });
    });

    // ===== Swatches
    const swatches = document.querySelectorAll(".swatch");
    swatches.forEach(s=>{
      s.addEventListener("click", ()=>{
        swatches.forEach(x=>x.classList.remove("active"));
        s.classList.add("active");
      });
    });

    // ===== Swatch "See More" functionality
const swatchMoreBtn = document.getElementById("swatchMoreBtn");
const moreSwatches = document.querySelectorAll(".more-swatch");
let swatchesExpanded = false;

swatchMoreBtn?.addEventListener("click", ()=>{
  swatchesExpanded = !swatchesExpanded;
  
  moreSwatches.forEach(swatch => {
    swatch.style.display = swatchesExpanded ? "block" : "none";
  });
  
  if(swatchesExpanded){
    swatchMoreBtn.innerHTML = '<i class="fa-solid fa-minus"></i>';
    swatchMoreBtn.title = "Show less";
  } else {
    swatchMoreBtn.innerHTML = '<i class="fa-solid fa-plus"></i>';
    swatchMoreBtn.title = "See more colors";
  }
});

// Make sure the existing swatch click functionality includes the hidden ones
document.querySelectorAll(".swatch").forEach(s=>{
  s.addEventListener("click", ()=>{
    document.querySelectorAll(".swatch").forEach(x=>x.classList.remove("active"));
    s.classList.add("active");
  });
});

    // ===== Chips (metal + type)
    function makeChipsActive(wrapperId){
      const wrap = document.getElementById(wrapperId);
      if(!wrap) return;
      const btns = wrap.querySelectorAll(".chip");
      btns.forEach(b=>{
        b.addEventListener("click", ()=>{
          btns.forEach(x=>x.classList.remove("active"));
          b.classList.add("active");
        });
      });
    }
    makeChipsActive("metalChips");
    makeChipsActive("typeChips");

    // ===== Sizes
    const sizes = document.querySelectorAll("#sizes .size");
    sizes.forEach(sz=>{
      sz.addEventListener("click", ()=>{
        sizes.forEach(x=>x.classList.remove("active"));
        sz.classList.add("active");
      });
    });

    // ===== Accordion
    const acc = document.getElementById("accordion");
    acc?.querySelectorAll(".acc-item").forEach(item=>{
      const btn = item.querySelector(".acc-btn");
      btn.addEventListener("click", ()=>{
        // single-open like Arata
        acc.querySelectorAll(".acc-item").forEach(i=>i!==item && i.classList.remove("active"));
        item.classList.toggle("active");
      });
    });
    // ===== Review Modal
    const reviewModal = document.getElementById("reviewModal");
    const reviewBackdrop = document.getElementById("reviewBackdrop");
    const openReviewModalBtn = document.getElementById("openReviewModalBtn");
    const closeReviewModalBtn = document.getElementById("closeReviewModalBtn");
    const cancelReviewBtn = document.getElementById("cancelReviewBtn");
    const submitReviewBtn = document.getElementById("submitReviewBtn");
    const toast = document.getElementById("toast");
    const reviewError = document.getElementById("reviewError");
    const starsInput = document.getElementById("starsInput");
    const ratingValue = document.getElementById("ratingValue");
    let selectedRating = 0;
    function openReviewModal(){
      reviewModal.setAttribute("aria-hidden", "false");
      reviewModal.classList.add("active");
      openOverlay();
    }
    function closeReviewModal(){
      reviewModal.setAttribute("aria-hidden", "true");
      reviewModal.classList.remove("active");
      closeOverlay();
      // reset form
      selectedRating = 0;
      ratingValue.textContent = "0/5";
      reviewError.classList.remove("show");
      starsInput.querySelectorAll(".star-btn").forEach(b=>b.classList.remove("active"));
      document.getElementById("reviewName").value = "";
      document.getElementById("reviewTitle").value = "";
      document.getElementById("reviewMessage").value = "";
    }
    openReviewModalBtn?.addEventListener("click", openReviewModal);
    closeReviewModalBtn?.addEventListener("click", closeReviewModal);
    cancelReviewBtn?.addEventListener("click", closeReviewModal);
    reviewBackdrop?.addEventListener("click", closeReviewModal);
    // Star rating selection
    starsInput?.querySelectorAll(".star-btn").forEach(btn=>{  
      btn.addEventListener("click", ()=>{
        selectedRating = parseInt(btn.getAttribute("data-value"));
        ratingValue.textContent = `${selectedRating}/5`;
        starsInput.querySelectorAll(".star-btn").forEach(b=>{
          const val = parseInt(b.getAttribute("data-value"));
          b.classList.toggle("active", val <= selectedRating);
        });
      });
    });
    // Submit review
    // submitReviewBtn?.addEventListener("click", ()=>{
    //   const name = document.getElementById("reviewName").value.trim();
    //   const message = document.getElementById("reviewMessage").value.trim();
    //   if(name === "" || message === "" || selectedRating === 0){
    //     reviewError.classList.add("show");
    //     return;
    //   }
    //   reviewError.classList.remove("show");
    //   // Here you would normally send the review to the server
    //   closeReviewModal();
    //   // Show toast
    //   toast.classList.add("show");
    //   setTimeout(()=>{ toast.classList.remove("show"); }, 3000);
    // });
    // Submit review
submitReviewBtn?.addEventListener("click", () => {
  const name      = document.getElementById("reviewName").value.trim();
  const title     = document.getElementById("reviewTitle").value.trim();
  const message   = document.getElementById("reviewMessage").value.trim();
  const productId = document.getElementById("reviewProductId").value;
  const storeUrl  = submitReviewBtn.dataset.url;

  if (name === "" || message === "" || selectedRating === 0) {
    reviewError.classList.add("show");
    return;
  }
  reviewError.classList.remove("show");

  submitReviewBtn.disabled    = true;
  submitReviewBtn.textContent = "Submitting…";

  fetch(storeUrl, {
    method: "POST",
    headers: {
      "Content-Type" : "application/json",
      "X-CSRF-TOKEN" : document.querySelector('meta[name="csrf-token"]').content,
      "Accept"       : "application/json",
    },
    body: JSON.stringify({
      product_id : productId,
      name       : name,
      title      : title,
      message    : message,
      rating     : selectedRating,
    }),
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      closeReviewModal();
      toast.textContent = "Review submitted ✓";
      toast.classList.add("show");
      setTimeout(() => toast.classList.remove("show"), 3000);
    } else {
      const errors = data.errors
        ? Object.values(data.errors).flat().join(" ")
        : (data.message || "Something went wrong.");
      reviewError.textContent = errors;
      reviewError.classList.add("show");
    }
  })
  .catch(() => {
    reviewError.textContent = "Network error. Please try again.";
    reviewError.classList.add("show");
  })
  .finally(() => {
    submitReviewBtn.disabled    = false;
    submitReviewBtn.textContent = "Submit Review";
  });
});

    // ===== Buy Now button
// const buyNowBtn = document.getElementById("buyNowBtn");
// buyNowBtn?.addEventListener("click", ()=>{
//   // Add your buy now logic here (e.g., direct checkout)
//   toast.textContent = "Proceeding to checkout...";
//   toast.classList.add("show");
//   setTimeout(()=>{ toast.classList.remove("show"); }, 2000);
// });

// ===== Buy Now button — Razorpay
const buyNowBtn = document.getElementById("buyNowBtn");

buyNowBtn?.addEventListener("click", () => {
  // @if(!Auth::guard('frontend')->check())
  //   window.location.href = "{{ route('frontend.login') }}";
  //   return;
  // @endif

  const productId = document.getElementById('addToCartBtn').dataset.productId;
  const variantId = document.getElementById('addToCartBtn').dataset.variantId || null;

  buyNowBtn.disabled    = true;
  buyNowBtn.textContent = 'Please wait…';

  fetch("{{ route('order.razorpay.create') }}", {
    method: 'POST',
    credentials: 'same-origin',  
    headers: {
      'Content-Type' : 'application/json',
      // 'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content,
      'Accept'       : 'application/json',
    },
    body: JSON.stringify({ product_id: productId, variant_id: variantId, quantity: 1 }),
  })
  .then(res => res.json())
  .then(data => {
    if (data.redirect) { window.location.href = data.redirect; return; }
    if (!data.success)  { showToast('Failed to initiate payment.'); return; }

    const options = {
      key           : data.key,
      amount        : data.amount,
      currency      : data.currency,
      name          : 'Ethnicoast',
      description   : data.product_name,
      order_id      : data.razorpay_order_id,
      prefill: {
        name  : '{{ Auth::guard("frontend")->user()?->name ?? "" }}',
        email : '{{ Auth::guard("frontend")->user()?->email ?? "" }}',
      },
      theme: { color: '#07203F' },

      handler: function (response) {
        fetch("{{ route('order.verify') }}", {
          method: 'POST',
          headers: {
            'Content-Type' : 'application/json',
            // 'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content,
            'Accept'       : 'application/json',
          },
          body: JSON.stringify({
            razorpay_order_id   : response.razorpay_order_id,
            razorpay_payment_id : response.razorpay_payment_id,
            razorpay_signature  : response.razorpay_signature,
            product_id          : data.product_id,
            variant_id          : data.variant_id,
            quantity            : data.quantity,
          }),
        })
        .then(r => r.json())
        .then(res => {
          if (res.success) {
            showToast('Order placed successfully ✓');
          } else {
            showToast(res.message || 'Payment failed.');
          }
        })
        .catch(() => showToast('Something went wrong.'));
      },

      modal: {
        ondismiss: function () {
          buyNowBtn.disabled    = false;
          buyNowBtn.textContent = 'Buy Now';
        }
      }
    };

    const rzp = new Razorpay(options);
    rzp.open();
  })
  .catch(() => showToast('Something went wrong.'))
  .finally(() => {
    buyNowBtn.disabled    = false;
    buyNowBtn.textContent = 'Buy Now';
  });
});

    // ===== Coupon functionality
    const couponBtn = document.getElementById("couponBtn");
    const productPrice = document.getElementById("productPrice");
    const discountedPrice = document.getElementById("discountedPrice");
    let couponApplied = false;
    const originalPrice = parseFloat("{{ $product->base_price }}");
    const discountPercent = 10; // 10% discount

    couponBtn?.addEventListener("click", ()=>{
      if(!couponApplied){
        // Apply coupon
        const newPrice = originalPrice - (originalPrice * discountPercent / 100);
        
        // Add strikethrough to original price
        productPrice.classList.add("strikethrough");
        
        // Show discounted price
      
        discountedPrice.textContent = `₹${Math.round(newPrice).toLocaleString('en-IN')}`;
        discountedPrice.style.display = "block";
        
        // Update coupon button appearance
        couponBtn.classList.add("applied");
        couponBtn.innerHTML = '<i class="fa-solid fa-check"></i> APPLIED';
        
        couponApplied = true;
        
        // Show success toast
        toast.textContent = "Coupon applied successfully! ✓";
        toast.classList.add("show");
        setTimeout(()=>{ toast.classList.remove("show"); }, 2000);
      } else {
        // Remove coupon
        productPrice.classList.remove("strikethrough");
        discountedPrice.style.display = "none";
        
        couponBtn.classList.remove("applied");
        couponBtn.innerHTML = '<i class="fa-solid fa-tag"></i> ETTH10';
        
        couponApplied = false;
        
        // Show removal toast
        toast.textContent = "Coupon removed";
        toast.classList.add("show");
        setTimeout(()=>{ toast.classList.remove("show"); }, 2000);
      }
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {

  const addToCartBtn = document.getElementById('addToCartBtn');
  if (!addToCartBtn) return;

  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
  let inCart = false;

  addToCartBtn.addEventListener('click', function () {
    inCart ? removeFromCart() : addToCart();
  });

  function addToCart() {
    const productId = addToCartBtn.dataset.productId;
    const variantId = addToCartBtn.dataset.variantId || null;
    const addUrl    = addToCartBtn.dataset.addUrl;

    setLoading(true);

    fetch(addUrl, {
      method: 'POST',
      headers: {
        'Content-Type' : 'application/json',
        'X-CSRF-TOKEN' : csrfToken,
        'Accept'       : 'application/json',
      },
      body: JSON.stringify({
        product_id : productId,
        variant_id : variantId,
        quantity   : 1,
      }),
    })
    .then(res => res.json())
    .then(data => {
     if (data.redirect) { window.location.href = data.redirect; return; }

      if (data.success) {
        inCart = true;
        addToCartBtn.textContent = 'Remove from Cart';
        addToCartBtn.classList.add('in-cart');
        updateCartCount(data.cart_count);
        showToast('Added to cart ✓');
      }
    })
    .catch(() => showToast('Something went wrong.'))
    .finally(() => setLoading(false));
  }

  function removeFromCart() {
    const productId = addToCartBtn.dataset.productId;
    const variantId = addToCartBtn.dataset.variantId || null;
    const removeUrl = addToCartBtn.dataset.removeUrl;

    setLoading(true);

    fetch(removeUrl, {
      method: 'DELETE',
      headers: {
        'Content-Type' : 'application/json',
        'X-CSRF-TOKEN' : csrfToken,
        'Accept'       : 'application/json',
      },
      body: JSON.stringify({
        product_id : productId,
        variant_id : variantId,
      }),
    })
    .then(res => res.json())
    .then(data => {
       if (data.redirect) { window.location.href = data.redirect; return; }
      if (data.success) {
        inCart = false;
        addToCartBtn.textContent = 'Add to Cart';
        addToCartBtn.classList.remove('in-cart');
        updateCartCount(data.cart_count);
        showToast('Removed from cart ✓');
      }
    })
    .catch(() => showToast('Something went wrong.'))
    .finally(() => setLoading(false));
  }

  function setLoading(state) {
    addToCartBtn.disabled    = state;
    addToCartBtn.textContent = state ? 'Please wait…' : (inCart ? 'Remove from Cart' : 'Add to Cart');
  }

  function updateCartCount(count) {
    const cartCountEl = document.getElementById('cartCount');
    if (cartCountEl) cartCountEl.textContent = count;
  }

  function showToast(msg) {
    const toast = document.getElementById('toast');
    if (!toast) return;
    toast.textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3000);
  }

  // ── Check if already in cart on page load ────────────────
 @auth('frontend')
    const alreadyInCart = {{ $product->carts->where('user_id', Auth::guard('frontend')->id())->count() > 0 ? 'true' : 'false' }};
    if (alreadyInCart) {
      inCart = true;
      addToCartBtn.textContent = 'Remove from Cart';
      addToCartBtn.classList.add('in-cart');
    }
  @endauth

});
  </script>
    @endpush
</body>
  
</html>