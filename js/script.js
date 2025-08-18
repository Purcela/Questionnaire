document.addEventListener('DOMContentLoaded', function() {

    //======================================================================
    // 1. რეგისტრაციის/ავტორიზაციის გვერდი (register.php)
    //======================================================================
    const loginFormBox = document.querySelector('.form-box.login');
    const signupFormBox = document.querySelector('.form-box.signup');
    const showSignupButton = document.querySelector('.registr-form');
    const showLoginButton = document.querySelector('.login-form');

    // რეგისტრაციის ფორმის ჩვენება
    if (showSignupButton) {
        showSignupButton.addEventListener('click', function() {
            loginFormBox.style.display = 'none';
            signupFormBox.style.display = 'flex';
        });
    }

    // ავტორიზაციის ფორმის ჩვენება
    if (showLoginButton) {
        showLoginButton.addEventListener('click', function() {
            signupFormBox.style.display = 'none';
            loginFormBox.style.display = 'flex';
        });
    }

    // რეგისტრაციის ფორმის მონაცემების გაგზავნა
    const signupForm = document.getElementById('signup-form');
    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('php/register_logic.php', { method: 'POST', body: formData })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    if (data.includes("წარმატებით")) {
                        window.location.href = 'index.php'; // გვერდის განახლება, რომ გამოჩნდეს პროფილის ბლოკი
                    }
                });
        });
    }

    // ავტორიზაციის ფორმის მონაცემების გაგზავნა
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('php/login_logic.php', { method: 'POST', body: formData })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    if (data.includes("წარმატებულად")) {
                        window.location.reload(); // გვერდის განახლება, რომ გამოჩნდეს პროფილის ბლოკი
                    }
                });
        });
    }
    
    // პაროლის შეცვლის ფორმის მონაცემების გაგზავნა
    const changePasswordForm = document.getElementById('change-password-form');
    if (changePasswordForm) {
        changePasswordForm.addEventListener('submit', function(e) {
            e.preventDefault();
             const formData = new FormData(this);
             fetch('php/change_password_logic.php', { method: 'POST', body: formData })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    if(data.includes("წარმატებით")){
                        this.reset(); // ფორმის გასუფთავება
                    }
                });
        });
    }


    //======================================================================
    // 2. დასრულებული კითხვარების გვერდი (completed.php)
    //======================================================================
    const showMyDraftsBtn = document.querySelector('.admin-created-drafts');
    const showUserDraftsBtn = document.querySelector('.user-complated-drafts');
    const adminDraftBox = document.querySelector('.admin-draftbox');
    const adminUserBox = document.querySelector('.admin-userbox');
    
    if (showMyDraftsBtn && showUserDraftsBtn) {
        // "ჩემი შექმნილი კითხვარები" ღილაკის ლოგიკა
        showMyDraftsBtn.addEventListener('click', () => {
            adminDraftBox.style.display = 'flex';
            adminUserBox.style.display = 'none';
            showMyDraftsBtn.classList.add('active');
            showUserDraftsBtn.classList.remove('active');
        });

        // "მომხმარებლის შევსებული" ღილაკის ლოგიკა
        showUserDraftsBtn.addEventListener('click', () => {
            adminDraftBox.style.display = 'none';
            adminUserBox.style.display = 'flex';
            showUserDraftsBtn.classList.add('active');
            showMyDraftsBtn.classList.remove('active');
            
            // თუ მონაცემები ჯერ არ ჩატვირთულა, ჩავტვირთოთ
            const userResultsContainer = adminUserBox.querySelector('.user-results');
            if (userResultsContainer.innerHTML.trim() === "") {
                 fetch('php/get_answers_logic.php')
                    .then(response => response.text())
                    .then(html => {
                        userResultsContainer.innerHTML = html;
                    });
            }
        });
    }


    //======================================================================
    // 3. კითხვარის შექმნის გვერდი (index.php) - ადმინის ხედი
    //======================================================================
    const finishedFormList = document.querySelector('.finished-form .question-list');
    
    // ელემენტის კლონირება და ფორმაში დამატება
    function addElementToForm(elementToClone) {
        if(finishedFormList && elementToClone) {
            const clone = elementToClone.cloneNode(true);
            // დამატების ღილაკების წაშლა კლონიდან, რომ ფორმაში არ გამოჩნდეს
            clone.querySelectorAll('.form-add').forEach(btn => btn.remove());
            finishedFormList.appendChild(clone);
        }
    }

    // სათაურის დამატება
    document.querySelector('.add-question-head')?.addEventListener('click', () => {
        const titleElement = document.querySelector('.question-head .Questionnaire-info');
        if(titleElement && titleElement.value.trim() !== "") {
            const titleBlock = document.createElement('div');
            titleBlock.innerHTML = `<h3>${titleElement.value}</h3><hr>`;
            titleBlock.dataset.type = 'header';
            titleBlock.dataset.value = titleElement.value;
            finishedFormList.prepend(titleBlock); // სათაური ყოველთვის თავში უნდა იყოს
        } else {
            alert("გთხოვთ, შეიყვანოთ კითხვარის სათაური.");
        }
    });

    // აუცილებელი ველების დამატება
    document.querySelector('.add-Necessary')?.addEventListener('click', () => {
        const necessaryBox = document.querySelector('.Necessary-box .Necessary');
        addElementToForm(necessaryBox);
    });

    // "ერთი სწორი პასუხი" კითხვის დამატება
     document.querySelector('.add-Questionnaire-1')?.addEventListener('click', () => {
        const questionnaireBox = document.querySelector('.Questionnaire-1');
        addElementToForm(questionnaireBox);
    });

    // "რამდენიმე სწორი პასუხი" კითხვის დამატება
    document.querySelector('.add-Questionnaire-2')?.addEventListener('click', () => {
        const questionnaireBox = document.querySelector('.Questionnaire-2');
        addElementToForm(questionnaireBox);
    });
    
    // "შეფასების" კითხვის დამატება
    document.querySelector('.add-rate')?.addEventListener('click', () => {
        const questionnaireBox = document.querySelector('.Questionnaire-3');
        addElementToForm(questionnaireBox);
    });

    // "ტექსტური პასუხის" კითხვის დამატება
    document.querySelector('.add-text-answer')?.addEventListener('click', () => {
        const questionnaireBox = document.querySelector('.Questionnaire-4');
        addElementToForm(questionnaireBox);
    });
    
    // კითხვარის გაგზავნა
    const adminSubmitBtn = document.querySelector('.admin-submit');
    if (adminSubmitBtn) {
        adminSubmitBtn.addEventListener('click', () => {
            const structure = [];
            
            // ვაგროვებთ ფორმის სტრუქტურას
            finishedFormList.querySelectorAll(':scope > div').forEach(el => {
                const item = {
                    type: el.className.split(' ')[0], // მაგ: 'Necessary', 'Questionnaire-1'
                    question: el.querySelector('textarea')?.value || '',
                    options: []
                };

                if (item.type === 'div') { // სათაურისთვის
                    item.type = el.dataset.type;
                    item.question = el.dataset.value;
                }
                
                // ვიღებთ პასუხების ვარიანტებს
                el.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(opt => {
                     item.options.push(opt.nextElementSibling.textContent.trim());
                });

                structure.push(item);
            });
            
            const emails = document.querySelector('.admin-input').value;
            const title = finishedFormList.querySelector('h3')?.textContent || 'უსათაურო კითხვარი';

            if(structure.length < 2) { // მინიმუმ სათაური და ერთი კითხვა
                alert('კითხვარი ცარიელია. გთხოვთ, დაამატოთ ველები.');
                return;
            }
            if(emails.trim() === "") {
                alert('გთხოვთ, მიუთითოთ მეილი(ები) გასაგზავნად.');
                return;
            }

            const formData = new FormData();
            formData.append('title', title);
            formData.append('structure', JSON.stringify(structure)); // ვაგზავნით JSON-ის სახით
            formData.append('emails', emails);

             fetch('php/create_questionnaire_logic.php', { method: 'POST', body: formData })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    if(data.includes('წარმატებით')) {
                        window.location.href = 'completed.php';
                    }
                });
        });
    }
// პასუხის ვარიანტების დინამიურად დამატების ლოგიკა
function addAnswerOption(containerSelector, inputType) {
    const answerContainer = document.querySelector(containerSelector);
    if (!answerContainer) return;

    const optionText = prompt("შეიყვანეთ პასუხის ვარიანტის ტექსტი:", "");
    if (optionText && optionText.trim() !== "") {
        const newOption = document.createElement('div');
        newOption.className = 'answer-option';

        const uniqueId = inputType + '-' + Date.now(); // უნიკალური ID-ის გენერაცია

        newOption.innerHTML = `
            <input type="${inputType}" id="${uniqueId}" name="question_${inputType}">
            <label for="${uniqueId}">${optionText}</label>
        `;

        // ვამატებთ ღილაკის წინ
        const addButton = answerContainer.querySelector('.form-add');
        answerContainer.insertBefore(newOption, addButton);
    		}
	}

	// "ერთი სწორი პასუხი" ვარიანტის დამატება
	document.querySelector('.add-select-one')?.addEventListener('click', (e) => {
    		e.preventDefault();
    		addAnswerOption('.Questionnaire-1 .answers-1', 'radio');
	});

	// "რამდენიმე სწორი პასუხი" ვარიანტის დამატება
	document.querySelector('.add-select-Several')?.addEventListener('click', (e) => {
    		e.preventDefault();
    		addAnswerOption('.Questionnaire-2 .answers-2', 'checkbox');
	});
});