// -----------------  login - registr -------------------------------- //

// ველოდებით DOM-ის სრულად ჩატვირთვას
document.addEventListener('DOMContentLoaded', function() {

    // ვიღებთ საჭირო ელემენტებს DOM-იდან
    const registerBox = document.querySelector('.register-box');
    const loginForm = document.querySelector('.form-box.login');
    const signupForm = document.querySelector('.form-box.signup');

    const showSignupButton = document.querySelector('.registr-form');
    const showLoginButton = document.querySelector('.login-form');

    // თავდაპირველად, რეგისტრაციის ფორმა დამალულია
    signupForm.style.display = 'none';

    // "დარეგისტრირდი" ღილაკზე დაჭერის ლოგიკა
    showSignupButton.addEventListener('click', function() {
        loginForm.style.display = 'none'; // ვმალავთ ავტორიზაციის ფორმას
        signupForm.style.display = 'flex'; // ვაჩენთ რეგისტრაციის ფორმას
    });

    // "სისტემაში შესვლა" ღილაკზე დაჭერის ლოგიკა
    showLoginButton.addEventListener('click', function() {
        signupForm.style.display = 'none'; // ვმალავთ რეგისტრაციის ფორმას
        loginForm.style.display = 'flex';  // ვაჩენთ ავტორიზაციის ფორმას
    });

});

// -------------------- draft admin panel -----------------------//

document.addEventListener('DOMContentLoaded', () => {
    // ვიღებთ ღილაკებს DOM-დან
    const showMyDraftsBtn = document.querySelector('.admin-created-drafts');
    const showUserDraftsBtn = document.querySelector('.user-complated-drafts');

    // ვიღებთ კონტეინერებს, რომელთა ჩვენება/დამალვაც გვინდა
    const adminDraftBox = document.querySelector('.admin-draftbox');
    const adminUserBox = document.querySelector('.admin-userbox');

    // ვამოწმებთ, რომ ყველა ელემენტი არსებობს, რათა თავიდან ავიცილოთ შეცდომები
    if (showMyDraftsBtn && showUserDraftsBtn && adminDraftBox && adminUserBox) {

        // საწყისი მდგომარეობა: ვაჩენთ "ჩემს ასლებს" და ვმალავთ "თანამშრომლისას"
        adminDraftBox.style.display = 'flex';
        adminUserBox.style.display = 'none';
        showMyDraftsBtn.classList.add('active'); // აქტიურ ღილაკს ვანიჭებთ კლასს

        // "ჩემი შენახული ასლები" ღილაკის ლოგიკა
        showMyDraftsBtn.addEventListener('click', () => {
            adminDraftBox.style.display = 'flex';
            adminUserBox.style.display = 'none';
            
            // აქტიური კლასის მართვა
            showMyDraftsBtn.classList.add('active');
            showUserDraftsBtn.classList.remove('active');
        });

        // "თანამშრომლის შევსებული კითხვარები" ღილაკის ლოგიკა
        showUserDraftsBtn.addEventListener('click', () => {
            adminDraftBox.style.display = 'none';
            adminUserBox.style.display = 'flex';

            // აქტიური კლასის მართვა
            showUserDraftsBtn.classList.add('active');
            showMyDraftsBtn.classList.remove('active');
        });
    }
});