<style>
    svg.tommy .node.female>rect {
        fill: #FF46A3;
    }

    hr {
        margin-top: 6px;
        margin-bottom: 6px;
    }

</style>
<div>
    @if (count(Auth::user()->familyTree) > 0)
        <div class="text-center">
            <h1>{{ Auth::user()->familyTree[0]->name }}</h1>
        </div>

        <div style="width:100%; height:auto;" id="tree"></div>
    @endif
</div>
<script>
    FamilyTree.templates.tommy_male.plus =
        '<circle cx="0" cy="0" r="15" fill="#ffffff" stroke="#aeaeae" stroke-width="1"></circle>' +
        '<line x1="-11" y1="0" x2="11" y2="0" stroke-width="1" stroke="#aeaeae"></line>' +
        '<line x1="0" y1="-11" x2="0" y2="11" stroke-width="1" stroke="#aeaeae"></line>';
    FamilyTree.templates.tommy_male.minus =
        '<circle cx="0" cy="0" r="15" fill="#ffffff" stroke="#aeaeae" stroke-width="1"></circle>' +
        '<line x1="-11" y1="0" x2="11" y2="0" stroke-width="1" stroke="#aeaeae"></line>';
    FamilyTree.templates.tommy_female.plus =
        '<circle cx="0" cy="0" r="15" fill="#ffffff" stroke="#aeaeae" stroke-width="1"></circle>' +
        '<line x1="-11" y1="0" x2="11" y2="0" stroke-width="1" stroke="#aeaeae"></line>' +
        '<line x1="0" y1="-11" x2="0" y2="11" stroke-width="1" stroke="#aeaeae"></line>';
    FamilyTree.templates.tommy_female.minus =
        '<circle cx="0" cy="0" r="15" fill="#ffffff" stroke="#aeaeae" stroke-width="1"></circle>' +
        '<line x1="-11" y1="0" x2="11" y2="0" stroke-width="1" stroke="#aeaeae"></line>';

    FamilyTree.templates.tommy_female.defs =
        '<g transform="matrix(0.05,0,0,0.05,-12,-9)" id="heart"><path fill="#F57C00" d="M438.482,58.61c-24.7-26.549-59.311-41.655-95.573-41.711c-36.291,0.042-70.938,15.14-95.676,41.694l-8.431,8.909  l-8.431-8.909C181.284,5.762,98.663,2.728,45.832,51.815c-2.341,2.176-4.602,4.436-6.778,6.778 c-52.072,56.166-52.072,142.968,0,199.134l187.358,197.581c6.482,6.843,17.284,7.136,24.127,0.654 c0.224-0.212,0.442-0.43,0.654-0.654l187.29-197.581C490.551,201.567,490.551,114.77,438.482,58.61z"/><g>';
    FamilyTree.templates.tommy_male.defs =
        '<g transform="matrix(0.05,0,0,0.05,-12,-9)" id="heart"><path fill="#F57C00" d="M438.482,58.61c-24.7-26.549-59.311-41.655-95.573-41.711c-36.291,0.042-70.938,15.14-95.676,41.694l-8.431,8.909  l-8.431-8.909C181.284,5.762,98.663,2.728,45.832,51.815c-2.341,2.176-4.602,4.436-6.778,6.778 c-52.072,56.166-52.072,142.968,0,199.134l187.358,197.581c6.482,6.843,17.284,7.136,24.127,0.654 c0.224-0.212,0.442-0.43,0.654-0.654l187.29-197.581C490.551,201.567,490.551,114.77,438.482,58.61z"/><g>';

    var jArray = <?php echo json_encode($members); ?>;

    var data = [];
    for (var i = 0; i < jArray.length; i++) {
        var pids = [];
        if (jArray[i].couple_id != null) {
            pids = jArray[i].couple_id.split(",");
            console.log(pids);
        }
        //format date jArray[i].dob to dd/mm/yyyy
        var dob = jArray[i].dob.split("-");
        var dob_format = dob[2] + "-" + dob[1] + "-" + dob[0];

        data.push({
            id: jArray[i].id,
            name: jArray[i].name,
            gender: jArray[i].gender,
            img: jArray[i].img,
            pids: pids,
            fid: jArray[i].father_id,
            mid: jArray[i].mother_id,
            dob: jArray[i].dob,
            dod: jArray[i].dod,

        })
    }
    var family = new FamilyTree(document.getElementById("tree"), {
        // mouseScrool: FamilyTree.action.none,

        nodeBinding: {
            field_0: "name",
            img_0: "img"
        },
        menu: {
            pdf: {
                text: "Export PDF"
            },
            png: {
                text: "Export PNG"
            },
            svg: {
                text: "Export SVG"
            },         
        },
        nodeMenu: {
            details: {
                text: "Chi tiết"
            },
            edit: {
                text: "Chỉnh sửa"
            }
        },
        nodes: data,

        editForm: {
            cancelBtn: 'Đóng',
            saveAndCloseBtn: 'Lưu',
            elements: [
            { type: 'textbox', label: 'Họ và tên', binding: 'name' },

            [
                { type: 'date', label: 'Ngày sinh', binding: 'dob' },
                { type: 'date', label: 'Ngày mất', binding: 'dod' }
            ],
            { type: 'textbox', label: 'Ảnh', binding: 'img', btn: 'Tải lên' },
        ],
        },

    });

    family.on('expcollclick', function(sender, isCollapsing, nodeId) {
        var node = family.getNode(nodeId);
        if (isCollapsing) {
            family.expandCollapse(nodeId, [], node.ftChildrenIds)
        } else {
            family.expandCollapse(nodeId, node.ftChildrenIds, [])
        }
        return false;
    });

    family.on('render-link', function(sender, args) {
        if (args.cnode.ppid != undefined)
            args.html += '<use data-ctrl-ec-id="' + args.node.id + '" xlink:href="#heart" x="' + (args.p.xb) +
            '" y="' + (args.p.ya) + '"/>';
        if (args.cnode.isPartner && args.node.partnerSeparation == 30)
            args.html += '<use data-ctrl-ec-id="' + args.node.id + '" xlink:href="#heart" x="' + (args.p.xb) +
            '" y="' + (args.p.yb) + '"/>';

    });
</script>
