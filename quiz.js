function checkEligibility() {
    const age = document.querySelector('input[name="age"]:checked')?.value;
    const recent = document.querySelector('input[name="recent"]:checked')?.value;
    const travel = document.querySelector('input[name="travel"]:checked')?.value;
    const meds = document.querySelector('input[name="meds"]:checked')?.value;

    let eligible = true;
    let message = 'You may be eligible to donate. Please consult with a healthcare professional for final confirmation.';

    if (age === 'no' || recent === 'yes' || travel === 'yes' || meds === 'yes') {
        eligible = false;
        message = 'You may not be eligible at this time. Check the detailed criteria below.';
    }

    document.getElementById('result').innerHTML = '<p>' + message + '</p>';

    // Detailed criteria
    document.getElementById('result').innerHTML += '<h3>Detailed Eligibility Criteria</h3><ul><li>Age: 18-65</li><li>Not donated in last 56 days</li><li>No recent travel to high-risk areas</li><li>No medications or conditions that disqualify</li></ul>';
}
