<?php

use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $columns = ['id', 'name', 'image_path', 'position', 'quote_body', 'quote_by', 'hierarchy', 'team_id', 'created_at', 'updated_at'];
        $teamMembers = [
            ['1', 'Clyde Dexter Rosales Santiago', 'public/uploads/9hCkjdsFOqq5WAvkIUDAeHJyxx0uguwKs9cyKz3z.jpg', 'Back End Developer', 'NA', 'NA', '3.10', '3', '2021-06-21 05:55:29', '2021-07-12 03:27:03'],
            ['11', 'Connor Curlewis', 'public/uploads/Saur11beIc9pMMJqzZDxOlXPDonHL7cjsE3sswd8.jpg', 'Content Producer', 'NA', 'NA', '4.70', '4', '2021-07-06 01:48:49', '2021-07-13 05:24:23'],
            ['12', 'Adam Curlewis', NULL, 'Videographer', 'NA', 'NA', '4.70', '4', '2021-07-06 01:49:55', '2021-07-06 01:49:55'],
            ['13', 'Micah Quinto', 'public/uploads/nFniRRpEDEJzwpzQfCzRxOZnl8Q2VFUMsptyOcpP.png', 'Multimedia Support', 'NA', 'NA', '4.70', '4', '2021-07-06 01:50:21', '2021-07-13 03:31:58'],
            ['14', 'Joseph Ianni', 'public/uploads/DJg8SRTfTUP3Whlhgm7fc98okBWj3W9dH7dxUNaF.jpg', 'Multimedia Team', 'NA', 'NA', '4.70', '4', '2021-07-06 01:51:01', '2021-07-13 02:35:58'],
            ['15', 'Shahbaz Parvez', 'public/uploads/4f7dYP5AT1WXxXBjGADVlCS5kx509lYqthdljnoJ.png', 'Affiliate Marketing Account Manager', 'NA', 'NA', '4.10', '4', '2021-07-06 01:52:24', '2021-07-14 07:34:48'],
            ['16', 'Tejashri Badole', NULL, 'Affiliate Marketing Account Manager', 'NA', 'NA', '4.10', '4', '2021-07-06 01:52:57', '2021-07-06 01:52:57'],
            ['17', 'Sid Samel', 'public/uploads/bgCFgdVyEvy9xkgN80FhpmV0IpYimRgTnm0NAiFt.jpg', 'Affiliate Manager', 'NA', 'NA', '4.10', '4', '2021-07-06 01:54:13', '2021-07-14 07:35:01'],
            ['18', 'Abhi Dabra', 'public/uploads/s66uz8L7zd7dsHayw8V17O4iyZMxqWgHxIRhnoVJ.png', 'Data Miner', 'NA', 'NA', '4.20', '4', '2021-07-06 01:55:37', '2021-07-14 07:35:17'],
            ['19', 'Karishma Chauhan', 'public/uploads/iyvysdWwA1UA1yYUjSbr1veP51tcB2Di87UxWsEI.jpg', 'Data Miner', 'NA', 'NA', '4.20', '4', '2021-07-06 01:56:14', '2021-07-13 11:15:32'],
            ['20', 'Sahil Sahotra', 'public/uploads/b6X50xzhcqcgAf5MQkZwsidxw6foq0e82nZ4ERf0.jpg', 'Data Miner', 'NA', 'NA', '4.20', '4', '2021-07-06 01:56:36', '2021-07-13 11:09:53'],
            ['21', 'Vincent Ventura', 'public/uploads/U5YE4l8K4MHqVbW9QSUKQf7jBfThlLQexOf4OXyL.jpg', 'Relationship Manager', 'NA', 'NA', '4.20', '4', '2021-07-06 01:56:58', '2021-07-13 03:31:43'],
            ['22', 'Andreja Nesic', 'public/uploads/zRS0DMByodB0TfovzPBWY8FBXD3ukQ2OP8bdhHep.png', 'Marketing Department Manager', 'NA', 'NA', '1.13', '4', '2021-07-06 01:58:07', '2021-07-14 07:33:29'],
            ['23', 'Sherwin Marcelino', 'public/uploads/2mc14bOKmnnZaVAka7UViQ5U9Yq9qQqxWlit9Mnh.png', 'Copywriter', 'NA', 'NA', '4.40', '4', '2021-07-06 01:59:03', '2021-07-13 05:46:04'],
            ['24', 'Sebastian Julian III', 'public/uploads/wvTOCWWQ4ULhGfzVeVYkbqO2Fg2jQ0iLCMRmRXwS.jpg', 'Copywriter', 'NA', 'NA', '4.40', '4', '2021-07-06 01:59:20', '2021-07-13 05:41:01'],
            ['25', 'Jan Michael Lapuz', 'public/uploads/2f6elXDiB74sl0ugE1PsbNLj5dNpahCVvZHqOy0J.jpg', 'Copywriting Team', 'NA', 'NA', '4.40', '4', '2021-07-06 01:59:45', '2021-07-13 05:41:14'],
            ['26', 'Angela Pauline Dorio', 'public/uploads/lZfTHnBzUEIWrVYcnSWcTBXh2QzYh82TkG1XatlT.png', 'Graphic Designer & Video Animator', 'NA', 'NA', '4.50', '4', '2021-07-06 02:00:59', '2021-07-13 05:21:14'],
            ['27', 'Anjali Ganesan', 'public/uploads/ppRL4oqcTj4A7HqenG4o0pfAvMAiKuDiw8GKoJw9.png', 'Graphic Designer & Video Animator', 'NA', 'NA', '4.50', '4', '2021-07-06 02:01:22', '2021-07-13 11:44:46'],
            ['28', 'Thenard Lecaros', 'public/uploads/K7r3ys8r6CadqLLXDM25HyamfpP3DAqWEe9pfamN.jpg', 'Graphic Designer & Video Animator', 'NA', 'NA', '4.50', '4', '2021-07-06 02:02:12', '2021-07-14 07:35:40'],
            ['29', 'Reymar Donasco', 'public/uploads/HWDHimt0oWsqs0hiUc0GBFTrk5FmHRlQk801lVxD.jpg', 'Creatives Team', 'NA', 'NA', '4.50', '4', '2021-07-06 02:02:50', '2021-07-13 08:54:54'],
            ['30', 'Vatsal Padhiyar', NULL, 'Conversion Tracking Expert & Data Analyst', 'NA', 'NA', '4.60', '4', '2021-07-06 02:04:26', '2021-07-06 02:13:11'],
            ['31', 'Pedro Campos', NULL, 'Data Analysis & Media Buying Team', 'NA', 'NA', '4.60', '4', '2021-07-06 02:05:26', '2021-07-11 23:00:14'],
            ['32', 'Filip Stanojevic', 'public/uploads/LgmXvJAZw3UtrhUPWnwSU7z86b1fgUe2g7KAAXX8.jpg', 'Email Marketing Team', 'NA', 'NA', '4.70', '4', '2021-07-06 02:06:27', '2021-07-13 11:12:33'],
            ['33', 'Muhammad Ali', 'public/uploads/SKIXZ5S9daG8muIWlptpLZ1FHQEsvlqDoUlVAg3D.jpg', 'Product Research Specialist', 'NA', 'NA', '4.90', '4', '2021-07-06 02:06:48', '2021-07-14 07:34:10'],
            ['34', 'Divesh Kumar', 'public/uploads/sUBOEDnoPuKpMgWhbG3jDRGvBdnBiNmiBX23ltNZ.jpg', 'SEO Team', 'NA', 'NA', '4.91', '4', '2021-07-06 02:10:34', '2021-07-13 08:48:03'],
            ['35', 'Deepika Katoch', 'public/uploads/ugcwEEyWgBg6iirZXk6yRkP2YDG6fQfX5SgPUEu3.jpg', 'SEO Specialist', 'NA', 'NA', '4.91', '4', '2021-07-06 02:11:02', '2021-07-13 08:54:42'],
            ['36', 'Diane Eunice Narciso', 'public/uploads/epeRDifnov5CWOmJmqCk46K65Jp9yJheFxBs5NnA.jpg', 'Content Team', 'NA', 'NA', '4.30', '4', '2021-07-06 02:15:21', '2021-07-13 08:44:27'],
            ['37', 'Zain Raza', NULL, 'Content Writer', 'NA', 'NA', '4.30', '4', '2021-07-06 02:15:58', '2021-07-06 02:15:58'],
            ['38', 'Muskan Fatima', NULL, 'Content Writer', 'NA', 'NA', '4.30', '4', '2021-07-06 02:16:40', '2021-07-06 02:16:40'],
            ['39', 'Shadman Khan', 'public/uploads/EEey8qHL31bjSz2vIN7HlzN1U3J0KHwSGPbdW5f5.png', 'Social Media Team', 'NA', 'NA', '4.92', '4', '2021-07-06 02:18:27', '2021-07-13 08:44:13'],
            ['40', 'Edguily de la Banda', NULL, 'Social Media Manager', 'NA', 'NA', '4.92', '4', '2021-07-06 02:18:58', '2021-07-06 02:20:33'],
            ['41', 'Muhammad Afzaal', 'public/uploads/pxoDaXFDgrhmTXQtEbTTifSecRE1f6NvVMhMcMFE.jpg', 'Development Project Manager', 'NA', 'NA', '3.00', '3', '2021-07-06 02:26:16', '2021-07-13 08:41:48'],
            ['42', 'Wale Owoade', 'public/uploads/y6ljK5uIY7s5lIubTY4cpTjGVwblyhkylxIAT8ZP.jpg', 'Development Product Manager', 'NA', 'NA', '3.00', '3', '2021-07-06 02:26:43', '2021-07-13 08:54:30'],
            ['43', 'Asanet Grigoryan', 'public/uploads/c1vb9FCYDXTjfZ7hnJa23kCZ8mNQukdLEvJqheQN.jpg', 'User Experience (UX) Designer', 'NA', 'NA', '3.70', '3', '2021-07-06 02:31:37', '2021-07-13 09:03:09'],
            ['44', 'Francisco Confiado', NULL, 'User Experience (UX) Designer', 'NA', 'NA', '3.70', '3', '2021-07-06 02:32:17', '2021-07-06 02:32:28'],
            ['45', 'Gerly Joy Cacatian', 'public/uploads/9AxCbRzsT14uzkRbQjKVUydboqVdyMgTdpIYrfAa.jpg', 'Quality Assurance', 'NA', 'NA', '3.20', '3', '2021-07-06 02:33:26', '2021-07-13 03:31:22'],
            ['46', 'Hassaan Ashraf', 'public/uploads/JbVNorSiksOCdI0JaLjui9xXAc81Cm4IZmCfe63d.png', 'Software QA Engineer', 'NA', 'NA', '3.23', '3', '2021-07-06 02:34:04', '2021-07-13 09:12:34'],
            ['47', 'Marvis Medrano', 'public/uploads/7i9XhghUfSuZUkPPyO1HVGfZgynZkkf8zONKTOq8.png', 'Software QA Engineer', 'NA', 'NA', '3.22', '3', '2021-07-06 02:34:34', '2021-07-13 08:58:34'],
            ['48', 'Robert Abella', 'public/uploads/q20GyDxPwJq6w5oi0nHkHWL6s6EivWA9OH44QQmH.jpg', 'Quality Assurance Analyst', 'NA', 'NA', '3.21', '3', '2021-07-06 02:35:06', '2021-07-13 05:47:16'],
            ['49', 'Misha Borsukevich', 'public/uploads/d058pMrebsVwO543uPfVLlqFDQLFSmJM9UhBy5js.jpg', 'Shopify Theme Team Lead', 'NA', 'NA', '3.30', '3', '2021-07-06 02:38:02', '2021-07-14 07:35:51'],
            ['50', 'Lukas Sketrys', 'public/uploads/E4Wg3xIRNwMZKh2ft5HIf6FSchzWPWdbNaatzo0r.jpg', 'Shopify Theme Developer', 'NA', 'NA', '3.32', '3', '2021-07-06 02:38:48', '2021-07-13 11:23:18'],
            ['51', 'Max Movchan', NULL, 'Shopify Theme Developer', 'NA', 'NA', '3.31', '3', '2021-07-06 02:39:42', '2021-07-06 02:39:42'],
            ['52', 'Talal Haider', 'public/uploads/ulsaI3eHVd4Wjza2sCzlLkUgfwKmd2nBJ8eqxdXc.jpg', 'Shopify Theme Developer', 'NA', 'NA', '3.33', '3', '2021-07-06 02:40:38', '2021-07-13 05:41:56'],
            ['53', 'Arabo Markarian', NULL, 'System Administration - Team Lead', 'NA', 'NA', '4.00', '3', '2021-07-06 02:47:00', '2021-07-06 02:47:00'],
            ['54', 'Ashan Mirando', NULL, 'System Administrator', 'NA', 'NA', '4.10', '3', '2021-07-06 02:47:25', '2021-07-06 02:47:25'],
            ['55', 'Edelwiess Sengco', 'public/uploads/ABVmtjEb5Okkn0omPCY08FZqzywJnMst6mIOdknZ.jpg', 'User Interface Designer', 'NA', 'NA', '3.60', '3', '2021-07-06 02:48:30', '2021-07-14 07:38:24'],
            ['57', 'Raluca Oana Voicu', 'public/uploads/R01ukeD9Qy1LaaedpRlxiILXiEf2f1RccVNLmUOE.jpg', 'User Interface (UI) Designer', 'NA', 'NA', '3.62', '3', '2021-07-06 02:49:34', '2021-07-14 07:33:40'],
            ['58', 'Zarbaz Khan', NULL, 'User Interface (UI) Designer', 'NA', 'NA', '3.63', '3', '2021-07-06 02:50:03', '2021-07-06 02:50:03'],
            ['59', 'Marang Marekimane', NULL, 'Documentation Specialist', 'NA', 'NA', '2.10', '2', '2021-07-06 02:51:58', '2021-07-06 02:51:58'],
            ['60', 'Zandro Guillermo', 'public/uploads/wmJ6Lsh0OVbH7KRsoSIoHQm1pXm2TU1BucUGtEmk.jpg', 'L1 Helpdesk Support', 'NA', 'NA', '2.20', '2', '2021-07-06 02:52:44', '2021-07-14 07:34:30'],
            ['61', 'Angelo Vic Montanez', NULL, 'L1 Helpdesk Specialist', 'NA', 'NA', '2.21', '2', '2021-07-06 02:53:47', '2021-07-06 02:53:58'],
            ['62', 'Jovenix Orpilla', 'public/uploads/CH03UCVZWCL3jPMQJADYk5mwAUMcKKI999zQ3Iog.jpg', 'L1 Helpdesk Specialist', 'NA', 'NA', '2.21', '2', '2021-07-06 02:54:19', '2021-07-13 03:32:16'],
            ['63', 'Rolf Geoffrey Aquino Reyna', 'public/uploads/Nq2bZjI5u7OeUxn8lByKIbobSvNV5FxDvqcCRjY2.jpg', 'L1 Helpdesk Specialist', 'NA', 'NA', '2.21', '2', '2021-07-06 02:54:42', '2021-07-13 02:35:43'],
            ['64', 'Carl Jasper Dumo', 'public/uploads/cCfF056RIYQeE3L2AAOFEamG685zz6LvSyjN94pW.jpg', 'L1 Helpdesk Specialist', 'NA', 'NA', '2.21', '2', '2021-07-06 02:55:00', '2021-07-14 07:37:17'],
            ['65', 'Raymund Cruz Reyes', 'public/uploads/r40ahYDKu8Zu8KimtPbu8gdwQZXhvQuPNseLCmvT.jpg', 'L1 Helpdesk Specialist', 'NA', 'NA', '2.21', '2', '2021-07-06 02:55:17', '2021-07-14 07:36:54'],
            ['66', 'Maria Lourdes Castillejos', 'public/uploads/EkmkNiCgYitPuMbdd4xATH7daitPTKCbUJIR7IrB.jpg', 'L1 Helpdesk Specialist', 'NA', 'NA', '2.21', '2', '2021-07-06 02:55:33', '2021-07-14 07:35:28'],
            ['67', 'Susmita Pacas', 'public/uploads/SBykObli6Xfuuir3XGqUWcYYdlwZIbFF2ODUg665.png', 'L1 Helpdesk Specialist', 'NA', 'NA', '2.21', '2', '2021-07-06 02:55:51', '2021-07-13 03:31:32'],
            ['68', 'Cherrie Balintag', NULL, 'Customer Support Representative', 'NA', 'NA', '2.10', '2', '2021-07-06 02:56:21', '2021-07-06 02:56:21'],
            ['69', 'Mirza Asad Baig', NULL, 'L2 Helpdesk Support', 'NA', 'NA', '2.30', '2', '2021-07-06 02:56:50', '2021-07-11 22:55:34'],
            ['70', 'Adil Abbas', NULL, 'L2 Helpdesk Specialist', 'NA', 'NA', '2.31', '2', '2021-07-06 02:57:15', '2021-07-06 02:57:15'],
            ['71', 'Abhishek Thakur', NULL, 'L2 Helpdesk Specialist', 'NA', 'NA', '2.31', '2', '2021-07-06 02:57:41', '2021-07-06 02:57:41'],
            ['72', 'Jun Salustiano Capegsan', NULL, 'L2 Helpdesk Specialist', 'NA', 'NA', '2.31', '2', '2021-07-06 02:58:04', '2021-07-06 02:58:04'],
            ['73', 'Mirasol Dela Paz Amil', 'public/uploads/vFNTKKbnLlYbPF9s68gjKbZo7b7LB8yTTgoKpncL.jpg', 'Corporate Department Manager', 'NA', 'NA', '1.14', '1', '2021-07-06 02:59:13', '2021-07-13 11:58:26'],
            ['74', 'Carizza Grace Bernardo', 'public/uploads/klGae0FrKn5nYiZAWxaJP7221dZ27o3iEMEt6XcS.jpg', 'Compliance & General Admin Assistant', 'NA', 'NA', '1.24', '1', '2021-07-06 02:59:39', '2021-07-13 05:41:42'],
            ['75', 'Abdul Najib Pangader', 'public/uploads/dRjjF2aZ7cbkq3x8gpzOMKUv5cmZ2eD6yqclSOEu.jpg', 'Accounting Assistant', 'NA', 'NA', '1.21', '1', '2021-07-06 03:00:19', '2021-07-13 09:03:22'],
            ['76', 'Sayyara Sher', 'public/uploads/k0pll7s1gI8GVEhkDHK4zS55axb1ollsJtDLiAko.jpg', 'Payroll Admin', 'NA', 'NA', '1.22', '1', '2021-07-06 03:01:00', '2021-07-13 08:41:26'],
            ['77', 'Dardan Bunjaku', 'public/uploads/jKvRftgxsxe6t2lnVSS5EfrYwqSkPr1Mg0GLbkzb.jpg', 'Contract Manager', 'NA', 'NA', '1.23', '1', '2021-07-06 03:01:28', '2021-07-14 07:33:06'],
            ['78', 'Carl Michael Yabut', 'public/uploads/rDp69310Cbh6e1V7lgUlIfhZD4Rdx6gwqpUPncZn.jpg', 'IT & Systems Administrator', 'NA', 'NA', '1.25', '1', '2021-07-06 03:01:50', '2021-07-13 05:41:32'],
            ['79', 'Aziz Rehman', NULL, 'Recruitment Specialist', 'NA', 'NA', '1.26', '1', '2021-07-06 03:02:15', '2021-07-06 03:04:14'],
            ['80', 'Raphael Bergeron', 'public/uploads/TcTtuABsBWRcrs1Tl8P6wD2Zz7KlpVONg5JjNq16.jpg', 'CEO', 'NA', 'NA', '1.10', '3', '2021-07-06 03:05:46', '2021-07-14 07:33:57'],
            ['81', 'Ricky Hayes', 'public/uploads/EanyAsc1tu6f994xoRedhiqeRFCEExR8BeIctGeY.png', 'Co-Founder', 'NA', 'NA', '1.12', '1', '2021-07-06 03:06:42', '2021-07-11 23:13:32'],
            ['82', 'Anil Gautam', 'public/uploads/VYDKco4m8iSmtp1zo1BvR8BOUTqMYVzfTo2fJs4f.jpg', 'Full-Stack Developer', 'NA', 'NZ', '3.50', '3', '2021-07-11 23:04:36', '2021-07-13 08:40:54'],
            ['83', 'Randy Corpuz', NULL, 'Full-Stack Developer', 'NA', 'NA', '3.50', '3', '2021-07-11 23:05:10', '2021-07-11 23:05:10'],
            ['84', 'Carl Genesis Jayectin', 'public/uploads/bknR6uu4HDHxK7PczwCWHmO2q5uNAyZo04f2EFbc.jpg', 'Full-Stack Developer', 'NA', 'NA', '3.50', '3', '2021-07-11 23:06:22', '2021-07-13 08:40:40'],
            ['85', 'Baneet Kumar Sharma', 'public/uploads/LFRBdCu17yHj1AT1yT2npvqX8EQAM66PV373MQ3M.jpg', 'Full-Stack Developer', 'NA', 'NA', '3.50', '3', '2021-07-11 23:07:16', '2021-07-13 11:17:05'],
            ['86', 'Kurt Ordoñez', 'public/uploads/EQSvrxjIbEexfTT8uFMQ9bhZArsIuGSSxXHiMQCl.jpg', 'Front-End Developer', 'NA', 'NA', '3.60', '3', '2021-07-11 23:07:54', '2021-07-13 11:44:58'],
            ['87', 'Mark Jan Enriquez', NULL, 'Front-End Developer', 'NA', 'NA', '3.60', '3', '2021-07-11 23:08:18', '2021-07-11 23:08:18'],
            ['88', 'Mukesh Kumar', 'public/uploads/PY4tOtbipZUmvmfq4fgwd1TTYdfhYbcTyLsa4pqC.png', 'Front-End Developer', 'NA', 'NA', '3.60', '3', '2021-07-11 23:08:50', '2021-07-13 08:40:27'],
            ['89', 'Muhammad Talal', 'public/uploads/5wN6t0QwPMjL3X8BhCzoYQmvJRV3v9KfacfPQrR4.jpg', 'Full-Stack Developer', 'NA', 'NA', '3.50', '3', '2021-07-11 23:09:45', '2021-07-13 05:42:22'],
            ['90', 'Francis Parilla', 'public/uploads/MveB0XII0DRbZsIyceJHAR6frYV7rcRKewhJgSEZ.jpg', 'Data Miner', 'NA', 'NA', '4.20', '4', '2021-07-13 12:11:24', '2021-07-14 07:32:38'],
            ['91', 'Fernandino Layno', NULL, 'User Interface (UI) Designer', 'NA', 'NA', '3.60', '3', '2021-07-13 12:13:06', '2021-07-13 12:13:06'],
        ];
         
        collect($teamMembers)->each(function($teamMember) use ($columns) {
            $data = [];

            collect($columns)->each(function($column, $columnKey) use ($teamMember, &$data) {
                $data[$column] = $teamMember[$columnKey];
            });

            \App\TeamMember::updateOrCreate(['id' => $data['id']], $data);
        });
    }
}
