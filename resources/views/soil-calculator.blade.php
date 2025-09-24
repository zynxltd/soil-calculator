<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>Soil Calculator</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
  <style>body{font-family:'Inter',ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial}</style>
</head>
<body class="min-h-screen bg-[#f6f7fb] grid place-items-center p-5">
  <div class="w-full max-w-[446px] bg-white rounded-[18px] shadow-[0_8px_28px_rgba(2,8,23,.08)] p-6 sm:p-7">
    <!-- Header -->
    <div class="text-center mb-7">
       <div class="w-12 h-12 rounded-full mx-auto mb-3 grid place-items-center bg-[#ECEEF3]">
         <svg class="h-5 w-5 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
           <rect x="6" y="3" width="12" height="18" rx="2"/>
           <path d="M8 8h8" />
           <path d="M8 12h2" />
           <path d="M12 12h2" />
           <path d="M16 12h0.01" />
           <path d="M8 16h2" />
           <path d="M12 16h2" />
           <path d="M16 16h0.01" />
         </svg>
       </div>
      <h1 class="text-[18px] font-semibold text-slate-800">Soil Calculator</h1>
      <p class="text-slate-500 text-[14px] leading-snug mt-1">Calculate the amount of soil needed for your project</p>
    </div>

    <!-- Errors -->
    <div id="errors" class="space-y-2"></div>

    <!-- Form -->
    <form id="form" class="space-y-4">
      <!-- Width -->
      <div>
         <label class="flex items-center gap-2 text-[13px] font-medium text-slate-700 mb-2">
           <x-lucide-ruler class="h-4 w-4 text-slate-500" />
           Width
         </label>
        <div class="relative">
          <input id="width" name="width" type="number" min="0.01" step="0.01" placeholder="Enter width" required class="w-full bg-[#f9fafb] border border-[#d1d5db] rounded-[10px] text-[15px] px-3.5 py-3 pr-28 outline-none focus:bg-white focus:border-[#3b82f6] focus:ring-4 focus:ring-blue-100 transition" />
          <span class="absolute inset-y-0 right-2 my-auto h-7 inline-flex items-center px-3 text-[12px] text-slate-600 bg-[#EEF0F3] border border-[#e5e7eb] rounded-full">meters</span>
        </div>
      </div>

      <!-- Length -->
      <div>
         <label class="flex items-center gap-2 text-[13px] font-medium text-slate-700 mb-2">
           <x-lucide-ruler class="h-4 w-4 text-slate-500" />
           Length
         </label>
        <div class="relative">
          <input id="length" name="length" type="number" min="0.01" step="0.01" placeholder="Enter length" required class="w-full bg-[#f9fafb] border border-[#d1d5db] rounded-[10px] text-[15px] px-3.5 py-3 pr-28 outline-none focus:bg-white focus:border-[#3b82f6] focus:ring-4 focus:ring-blue-100 transition" />
          <span class="absolute inset-y-0 right-2 my-auto h-7 inline-flex items-center px-3 text-[12px] text-slate-600 bg-[#EEF0F3] border border-[#e5e7eb] rounded-full">meters</span>
        </div>
      </div>

      <!-- Depth -->
      <div>
         <label class="flex items-center gap-2 text-[13px] font-medium text-slate-700 mb-2">
           <x-feathericon-box class="h-4 w-4 text-slate-500" />
           Depth
         </label>
        <div class="relative">
          <input id="depth" name="depth" type="number" min="0.01" step="0.01" placeholder="Enter depth" required class="w-full bg-[#f9fafb] border border-[#d1d5db] rounded-[10px] text-[15px] px-3.5 py-3 pr-28 outline-none focus:bg-white focus:border-[#3b82f6] focus:ring-4 focus:ring-blue-100 transition" />
          <span class="absolute inset-y-0 right-2 my-auto h-7 inline-flex items-center px-3 text-[12px] text-slate-600 bg-[#EEF0F3] border border-[#e5e7eb] rounded-full">meters</span>
        </div>
      </div>

      <!-- Density -->
      <div>
         <label class="flex items-center gap-2 text-[13px] font-medium text-slate-700 mb-2">
           <x-lucide-layers class="h-4 w-4 text-slate-500" />
           Soil Density
         </label>
        <div class="relative">
          <select id="soil_type" name="soil_type" required class="w-full appearance-none bg-[#f9fafb] border border-[#d1d5db] rounded-[10px] text-[15px] px-3.5 py-3 pr-10 outline-none focus:bg-white focus:border-[#3b82f6] focus:ring-4 focus:ring-blue-100 transition">
            <option value="">Select density type</option>
            <option value="intensive">Intensive (1.3 tonnes/m³)</option>
            <option value="extensive">Extensive (1.1 tonnes/m³)</option>
          </select>
           <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
             <path d="m6 9 6 6 6-6"/>
           </svg>
        </div>
      </div>

      <button id="btn" type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-[#1e293b] hover:bg-[#0f172a] text-white font-semibold rounded-[10px] py-3.5 text-[15px] transition"> 
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
          <rect x="6" y="3" width="12" height="18" rx="2"/>
          <path d="M8 8h8"/>
        </svg>
        Calculate Soil Needed
      </button>
    </form>

    <!-- Results -->
    <div id="results" class="hidden bg-[#f9fafb] border border-[#e5e7eb] rounded-[12px] p-4 mt-4">
      <div class="flex items-center gap-2 font-semibold text-slate-700 mb-3">
        <x-feathericon-box class="h-5 w-5 text-slate-600" />
        Results
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="text-center bg-white rounded-lg p-3 border border-[#e5e7eb]">
          <div class="text-[12px] text-slate-500 mb-1">Cubic Meters</div>
          <div id="cubic-meters" class="text-[16px] sm:text-[18px] font-semibold text-slate-800">0.75 m³</div>
        </div>
        <div class="text-center bg-white rounded-lg p-3 border border-[#e5e7eb]">
          <div class="text-[12px] text-slate-500 mb-1">Liters</div>
          <div id="liters" class="text-[16px] sm:text-[18px] font-semibold text-slate-800">750 L</div>
        </div>
        <div class="text-center bg-white rounded-lg p-3 border border-[#e5e7eb] sm:col-span-2">
          <div class="text-[12px] text-slate-500 mb-1">Bags Needed</div>
          <div id="bags-needed" class="text-[14px] sm:text-[16px] font-semibold text-slate-800 leading-tight">2 × 25kg</div>
        </div>
        <div class="text-center bg-white rounded-lg p-3 border border-[#e5e7eb] sm:col-span-2">
          <div class="text-[12px] text-slate-500 mb-1">Total Cost</div>
          <div id="total-cost" class="text-[16px] sm:text-[18px] font-semibold text-slate-800">£45.90</div>
        </div>
      </div>
      <div id="bag-breakdown" class="mt-4 pt-4 border-t border-[#e5e7eb]"></div>
      <div id="waste" class="mt-3 text-[13px] rounded-md px-3 py-2"></div>
    </div>
  </div>

  <script>
    const form = document.getElementById('form');
    const btn = document.getElementById('btn');
    const resEl = document.getElementById('results');
    const errs = document.getElementById('errors');

    form.addEventListener('submit', async (e)=>{
      e.preventDefault();
      errs.innerHTML = '';
       btn.disabled = true; btn.classList.add('opacity-70'); btn.innerHTML = '<svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg> Calculating...';
      try{
        const data = Object.fromEntries(new FormData(form).entries());
         const r = await fetch('/calculate', {
           method:'POST', 
           headers:{
             'Content-Type':'application/json',
             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
           }, 
           body: JSON.stringify(data)
         });
        const j = await r.json();
        if(j.success){ render(j.data); }
        else{ showErrors(j.errors || {general:[j.message || 'Unable to calculate']}); }
      }catch(err){ showErrors({general:['An error occurred. Please try again.']}); }
       finally{ btn.disabled = false; btn.classList.remove('opacity-70'); btn.innerHTML = '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg> Calculate Soil Needed'; }
    });

    function render(data){
      document.getElementById('cubic-meters').textContent = `${data.cubic_meters} m³`;
      document.getElementById('liters').textContent = `${data.liters} L`;
      document.getElementById('total-cost').textContent = `£${Number(data.total_cost).toFixed(2)}`;
      // Create a more mobile-friendly bags needed display
      const bagsNeeded = data.bag_combination.bags.map(b=>`${b.count} × ${b.name}`).join(' + ');
      document.getElementById('bags-needed').textContent = bagsNeeded;

      const bd = document.getElementById('bag-breakdown');
      bd.innerHTML = '<h4 class="text-[14px] font-semibold text-slate-800 mb-3 flex items-center gap-2"><svg class="h-4 w-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>Bag Breakdown</h4>';
      
      data.bag_combination.bags.forEach((b, index) => {
        const row = document.createElement('div');
        row.className = 'bg-white border border-[#e5e7eb] rounded-lg p-3 mb-2 shadow-sm hover:shadow-md transition-shadow';
        
        // Create a more detailed bag item layout
        row.innerHTML = `
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                <span class="text-[12px] font-semibold text-blue-700">${b.count}</span>
              </div>
              <div>
                <div class="text-[14px] font-medium text-slate-800">${b.name}</div>
                <div class="text-[12px] text-slate-500">${b.weight}kg each</div>
              </div>
            </div>
            <div class="text-right">
              <div class="text-[14px] font-semibold text-slate-800">£${(b.count*b.price).toFixed(2)}</div>
              <div class="text-[12px] text-slate-500">£${b.price} each</div>
            </div>
          </div>
        `;
        
        bd.appendChild(row);
      });

      const w = document.getElementById('waste');
      const pct = Number(data.bag_combination.wastage_percentage);
      const isEfficient = pct <= 20;
      
      w.className = `mt-3 text-[13px] rounded-lg px-4 py-3 border ${isEfficient ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-amber-50 border-amber-200 text-amber-800'}`;
      
      w.innerHTML = `
        <div class="flex items-center gap-2">
          <div class="w-5 h-5 rounded-full flex items-center justify-center ${isEfficient ? 'bg-emerald-100' : 'bg-amber-100'}">
            ${isEfficient ? '✅' : '⚠️'}
          </div>
          <div>
            <div class="font-medium">${isEfficient ? 'Efficient' : 'High wastage'}: ${pct}%</div>
            <div class="text-[11px] opacity-75">${data.bag_combination.wastage_kg}kg excess</div>
          </div>
        </div>
      `;

      resEl.classList.remove('hidden');
      resEl.scrollIntoView({behavior:'smooth', block:'nearest'});
    }

    function showErrors(map){
      errs.innerHTML = Object.values(map).flat().map(m=>`<div class='bg-red-50 border border-red-200 text-red-600 text-[13px] rounded-md px-3 py-2'>${m}</div>`).join('');
    }
  </script>
</body>
</html>
