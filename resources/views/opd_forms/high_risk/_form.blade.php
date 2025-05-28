@php
    $form = $opd_form ?? null;

    if (! function_exists('fv')) {
        function fv(string $key, $form) {
            return old($key, data_get($form, "data.{$key}", ''));
        }
    }

    $left = [
        '# SCARRED UTERUS / PREVIOUS CESAREAN' => 'scarred_uterus',
        '# DIABETES MELLITUS'                  => null,
        'gest_dm'    => 'Gestational Diabetes Mellitus',
        'overt_dm'   => 'Pre-gestational or Overt Diabetes',
        '# HYPERTENSIVE DISORDERS'             => null,
        'pre_eclampsia'        => 'Pre-eclampsia',
        'severe_pre_eclampsia' => 'Pre-eclampsia with severe features',
        'chronic_htn'          => 'Chronic Hypertension',
        'chronic_htn_pre_eclamp'=> 'Chronic Hypertension with Pre-eclampsia',
        '# OTHER MEDICAL/SURG COMPLICATIONS'   => null,
        'anemia'                => 'Anemia',
        'other_hematologic'     => 'Other Hematologic Disorder',
        'bronchial_asthma'      => 'Bronchial Asthma',
        'cong_hd'               => 'Congenital Heart Disease (ASD, VSD, etc.)',
        'acquired_hd'           => 'Acquired Heart Disease (RHD, etc.)',
        'goiter'                => 'Goiter',
        'hypothyroidism'        => 'Hypothyroidism',
        'hyperthyroidism'       => 'Hyperthyroidism',
        'chronic_renal'         => 'Chronic Renal Disease',
        'copd'                  => 'Chronic Obstructive Pulmonary Disease',
        'hypokalemia'           => 'Hypokalemia',
        'extra_genital_ca'      => 'Extra-Genital Cancer (lung, breast, etc.)',
        'epilepsy'              => 'Epilepsy / Seizure Disorder',
        'other_neuro'           => 'Other Neurologic Disease',
        'musculo_skeletal'      => 'Musculo-skeletal Disorder',
        'psychiatric'           => 'Psychiatric Disorder',
        'others_med_surg'       => 'Others (specify)',
        '# GENERATIVE TRACT DISORDERS'         => null,
        'cong_ut_anomaly'       => 'Congenital Anomalies of Uterus',
        'incompetent_cervix'    => 'Incompetent Cervix',
        'myoma'                 => 'Myoma',
        'ovarian_cyst'          => 'Ovarian Cyst / New growth',
        'pcos'                  => 'Polycystic Ovaries',
        'genital_tract_ca'      => 'Genital Tract Cancer (cervical, ovarian, etc.)',
        'others_generative'     => 'Others (specify)',
        '# HISTORY OF INFERTILITY'             => 'history_infertility',
        '# HISTORY OF H-MOLE (within 1 year)'  => 'history_h_mole',
        '# RH NEGATIVE BLOOD TYPE'             => 'rh_negative',
        '# FETAL CONGENITAL ANOMALY'           => 'fetal_congenital_anomaly',
    ];

    $right = [
        'poor_ob_history_label' => '# POOR OBSTETRIC HISTORY (specify)',
        'poor_ob_history'       => 'poor_ob_history',
        'young_primigravida'    => 'Young Primigravida (≤ 18 yrs)',
        'young_gravida'         => 'Young Gravida',
        'elderly_primigravida'  => 'Elderly Primigravida (≥ 35 yrs)',
        'elderly_gravida'       => 'Elderly Gravida / Advanced Maternal Age',
        'underweight'           => 'Underweight (BMI ≤ 19)',
        'obese'                 => 'Obese (BMI ≥ 30)',
        'grandmultiparity'      => 'Grandmultiparity (≥ Para 5)',
        'nearing_postdatism'    => 'Nearing Postdatism (≥ 41 but < 42 weeks)',
        'postdatism'            => 'Postdatism (≥ 42 weeks)',
        '# MULTIPLE GESTATION'  => null,
        'twins'                 => 'Twins',
        'triplets'              => 'Triplets',
        'others_multiple'       => 'Others (specify)',
        '# ANTEPARTUM HEMORRHAGE' => null,
        'threatened_abortion'   => 'Threatened Abortion',
        'placenta_previa'       => 'Placenta Previa',
        'placenta_accreta'      => 'Placenta Accreta / Increta / Percreta',
        'abruption_placenta'    => 'Abruption Placenta',
        'iugr'                  => 'Intrauterine Growth Restriction',
        'fetal_macrosomia'      => 'Fetal Macrosomia (> 4 kg)',
        'oligohydramnios'       => 'Oligohydramnios / Anhydramnios',
        'polyhydramnios'        => 'Polyhydramnios / Hydramnios',
        'preterm_labor'         => 'Preterm Labor',
        '# PRE-LABOR RUPTURE OF MEMBRANES' => null,
        'preterm_prom'          => 'Preterm PROM',
        'term_prom'             => 'Term PROM',
        '# INFECTIONS'          => null,
        'uti'                   => 'Urinary Tract Infection',
        'uri'                   => 'Upper Respiratory Tract Infection',
        'pneumonia'             => 'Pneumonia',
        'tuberculosis'          => 'Tuberculosis',
        'bacterial_vaginosis'   => 'Bacterial Vaginosis',
        'trichomoniasis'        => 'Trichomoniasis',
        'hepatitis_b'           => 'Hepatitis B',
        'syphilis'              => 'Syphilis',
        'hpv'                   => 'Human Papillomavirus (genital warts)',
        'hiv'                   => 'HIV',
        'others_infection'      => 'Others (specify)',
    ];
@endphp

<form method="POST" action="{{ $postRoute }}">
  @csrf
  @if(! empty($needPut)) @method('PUT') @endif
  {{-- ── Metadata ── --}}
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <label class="form-label">Form Name</label>
      <!-- no name attribute -->
      <input
        type="text"
        class="form-control"
        value="Identification of High Risk"
        readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label">Form #</label>
      <input
        type="text"
        class="form-control"
        value="OPD-F-09"
        readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label">Department</label>
      <input
        type="text"
        class="form-control"
        value="OB"
        readonly>
    </div>
  </div>



  {{-- ── Patient selector + autofill ── --}}
  <div class="row g-3 mb-5">  {{-- increased bottom margin --}}
    <div class="col-md-12">
      <label class="form-label">Select Patient</label>
      <select id="patient_id" name="patient_id" class="form-control"></select>
      @error('patient_id')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
      <label class="form-label">Last Name</label>
      <input name="last_name" type="text" class="form-control" readonly>
    </div>
    <div class="col-md-3">
      <label class="form-label">Given Name</label>
      <input name="given_name" type="text" class="form-control" readonly>
    </div>
    <div class="col-md-3">
      <label class="form-label">Middle Name</label>
      <input name="middle_name" type="text" class="form-control" readonly>
    </div>
    <div class="col-md-1">
      <label class="form-label">Age</label>
      <input name="age" type="number" class="form-control" readonly>
    </div>
    <div class="col-md-2">
      <label class="form-label">Sex</label>
      <input name="sex" type="text" class="form-control" readonly>
    </div>
  </div>

  {{-- ── Risk Factors ── --}}
  <div class="mb-3"><h4 class="fw-bold">Risk Factors</h4></div>

  @php $selected = fv('risks', $form) ?: []; @endphp
  <div class="row g-4">
    <div class="col-md-6">
      @foreach($left as $value => $label)
        @if(str_starts_with($label ?? $value, '#'))
          <h6 class="mt-3 fw-bold">{{ ltrim($label ?? $value, '# ') }}</h6>
        @else
          <div class="form-check small">
            <input class="form-check-input"
                   type="checkbox"
                   name="risks[]"
                   value="{{ $value }}"
                   {{ in_array($value, $selected) ? 'checked' : '' }}>
            <label class="form-check-label">{{ $label }}</label>
          </div>
          @if(in_array($value, ['others_med_surg','others_generative','fetal_congenital_anomaly']))
            <input type="text"
                   name="{{ $value }}_specify"
                   value="{{ fv("{$value}_specify", $form) }}"
                   class="form-control form-control-sm mb-2"
                   placeholder="Specify">
          @endif
        @endif
      @endforeach
    </div>
    <div class="col-md-6">
      @foreach($right as $value => $label)
        @if(str_starts_with($label ?? $value, '#'))
          <h6 class="mt-3 fw-bold">{{ ltrim($label ?? $value, '# ') }}</h6>
        @else
          <div class="form-check small">
            <input class="form-check-input"
                   type="checkbox"
                   name="risks[]"
                   value="{{ $value }}"
                   {{ in_array($value, $selected) ? 'checked' : '' }}>
            <label class="form-check-label">{{ $label }}</label>
          </div>
          @if(in_array($value, ['poor_ob_history','others_multiple','others_infection']))
            <input type="text"
                   name="{{ $value }}_specify"
                   value="{{ fv("{$value}_specify", $form) }}"
                   class="form-control form-control-sm mb-2"
                   placeholder="Specify">
          @endif
        @endif
      @endforeach
    </div>
  </div>

  {{-- ── Buttons ── --}}
  <div class="mt-4 text-end">
    @if(! empty($showButtons))
      <button class="btn btn-primary">Save</button>
      <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
    @endif
  </div>
</form>

@push('scripts')
<script>
$(function () {
    $('#patient_id').select2({
        placeholder: 'Type to search patient…',
        ajax: {
            url: '{{ route('patients.search') }}',
            dataType: 'json',
            delay: 250,
            data: params => ({ q: params.term || '' }),
            processResults: data => ({ results: data.results })
        },
        minimumInputLength: 0,
        width: '100%'
    });

    $('#patient_id')
      .on('focus click', function () {
         $(this).select2('open');
      })
      .on('select2:select', e => {
        const p = e.params.data;
        $('input[name=last_name]').val(p.last_name);
        $('input[name=given_name]').val(p.given_name);
        $('input[name=middle_name]').val(p.middle_name);
        $('input[name=age]').val(p.age);
        $('input[name=sex]').val(p.sex);
    });
});
</script>
@endpush
